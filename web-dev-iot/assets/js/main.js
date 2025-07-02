// assets/js/main.js
import { SensorCard } from './SensorCard.js';
import { SensorTable } from './SensorTable.js';

const cardsEl  = document.getElementById('sensor-cards');
const form     = document.getElementById('data-form');
const search   = document.getElementById('search');
const newSensorForm = document.getElementById('new-sensor-form');
const newModalEl    = document.getElementById('newSensorModal');
const newModal      = new bootstrap.Modal(newModalEl);
let tableInstance;

function createNewSensorCard() {
  const col = document.createElement('div');
  col.className = 'col-6 col-md-4 col-lg-3';
  col.innerHTML = `
    <div class="card h-100 shadow-sm d-flex align-items-center
                justify-content-center text-primary"
         style="cursor:pointer; font-size:2rem;">
      <div>+</div>
    </div>`;
  col.querySelector('.card').addEventListener('click', () => {
    newSensorForm.reset();
    newModal.show();
  });
  return col;
}

newSensorForm.addEventListener('submit', async e => {
  e.preventDefault();
  const fd   = new FormData(newSensorForm);
  const type = fd.get('type');
  const unit = fd.get('unit');

  const res = await fetch('/api/sensors', {
    method:  'POST',
    headers: { 'Content-Type':'application/json' },
    body:    JSON.stringify({ type, unit })
  });
  if (res.ok) {
    newModal.hide();
    await loadSensors();
    await loadData();
  } else {
    const err = await res.json().catch(()=>({}));
    alert('Fehler: ' + (err.error||res.status));
  }
});


// 2) Angepasste loadSensors()
export async function loadSensors() {
  const res = await fetch('/api/sensors');
  const sensors = await res.json();
  const cardsEl = document.getElementById('sensor-cards');

  cardsEl.innerHTML = '';

  // Wenn Admin, zuerst “+”-Karte einfügen
  if (window.currentUser?.role === 'admin') {
    cardsEl.appendChild(createNewSensorCard());
  }

  // Danach alle existierenden Sensor-Karten
  sensors.forEach(s => {
    cardsEl.appendChild(new SensorCard(s).render());
  });
}

async function loadData() {
  const res = await fetch('/api/sensordata');
  const data = await res.json();
  tableInstance = new SensorTable(data);
  tableInstance.render();
}

document.addEventListener('DOMContentLoaded', async () => {
  // 2) Expose them _after_ they exist
  window.loadSensors = loadSensors;
  window.loadData    = loadData;

  form.onsubmit = async e => {
    e.preventDefault();
    const fd = new FormData(form);
    const payload = {
      sensor_type: fd.get('sensor_type'),
      measurement: fd.get('measurement'),
      timestamp:   fd.get('timestamp')
    };
    const res = await fetch('/api/sensordata', {
      method:  'POST',
      headers: { 'Content-Type': 'application/json' },
      body:    JSON.stringify(payload)
    });
    if (res.ok) {
      form.reset();
      await loadSensors();
      await loadData();
    } else {
      const err = await res.json();
      alert(JSON.stringify(err));
    }
  };

  search.addEventListener('input', () => {
    if (tableInstance) {
      tableInstance.filter(search.value);
    }
  });
  
  // Initial load
  await loadSensors();
  await loadData();

  const es = new EventSource('/public/events.php');

  es.onmessage = e => {
    // e.lastEventId enthält die ID des letzten Datensatzes
    const sd = JSON.parse(e.data);

    // 1) Du hast tableInstance.data als Array von Objekten mit id-Feld
    const exists = tableInstance.data.some(r => r.id === sd.id);
    if (!exists) {
      // nur neu hinzufügen, wenn noch nicht vorhanden
      tableInstance.data.push(sd);
      tableInstance.render();
    }

    // 2) In SensorCard updaten (falls du letzte Messung anzeigen willst)
    const card = document.querySelector(`.sensor-card[data-id="${sd.sensor_id}"]`);
    if (card) {
      const measEl = card.querySelector('.measurement');
      const tsEl   = card.querySelector('.ts');
      measEl.textContent = sd.measurement;
      tsEl.textContent   = new Date(sd.timestamp)
        .toLocaleString('de-DE',{ dateStyle:'short', timeStyle:'short' });
        // JS-Animation: grüner Schatten, der in 1,5s ausfadet
      card.animate([
        { boxShadow: '0 0 12px rgba(0,255,0,0.8)' },
        { boxShadow: '0 0   0px rgba(0,255,0,0)' }
      ], {
        duration: 1500,
        easing: 'ease-out'
      });
    }
  };
});
