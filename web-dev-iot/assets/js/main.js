// assets/js/main.js
import { SensorCard } from './SensorCard.js';
import { SensorTable } from './SensorTable.js';

//Konstanten und Variablen
const cardsEl  = document.getElementById('sensor-cards');
const form     = document.getElementById('data-form');
const search   = document.getElementById('search');
const newSensorForm = document.getElementById('new-sensor-form');
const newModalEl    = document.getElementById('newSensorModal');
const newModal      = new bootstrap.Modal(newModalEl);
let tableInstance;

//Funktion zur Erstellung einer neuen Sensorenkarte
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

//Event nach dem die Sensorendaten in der Form abgeschickt werden
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
    await fillTimestamp();
  } else {
    const err = await res.json().catch(()=>({}));
    alert('Fehler: ' + (err.error||res.status));
  }
});


// Funktion zum Laden der Sensoren und dessen Rendering
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

  // Zusätzlich: Dropdown-Liste befüllen
  const selectEl = document.getElementById('sensor_type');
  if (selectEl) {
    selectEl.innerHTML = '<option value="">Bitte Sensor auswählen</option>';
    sensors.forEach(s => {
      const option = document.createElement('option');
      option.value = s.type; // passt an dein Sensor-Objekt an
      option.textContent = s.type;
      selectEl.appendChild(option);
    });
  }
  fillTimestamp();
}

// Funktion zum Laden der Sensorendaten und Rendering
async function loadData() {
  const res = await fetch('/api/sensordata');
  const data = await res.json();
  tableInstance = new SensorTable(data);
  tableInstance.render();
}

//Funktion zum vorbelegen des Zeitstempels
export async function fillTimestamp(){
    const now = new Date();
  const local = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
    .toISOString()
    .slice(0,16);
  document.getElementById('timestamp').value = local;
}

//Event, wenn Seite vollständig geladen wurde und mit der gearbeitet werden kann
document.addEventListener('DOMContentLoaded', async () => {
  window.loadSensors = loadSensors;
  window.loadData    = loadData;
  window.fillTimestamp = fillTimestamp;


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
  await fillTimestamp();

  const es = new EventSource('/public/events.php');

  es.onmessage = e => {
    // e.lastEventId enthält die ID des letzten Datensatzes
    const sd = JSON.parse(e.data);

    const exists = tableInstance.data.some(r => r.id === sd.id);
    if (!exists) {
      // nur neu hinzufügen, wenn noch nicht vorhanden
      tableInstance.data.push(sd);
      tableInstance.render();
    }

    // In SensorCard updaten (falls du letzte Messung anzeigen willst)
    const card = document.querySelector(`.sensor-card[data-id="${sd.sensor_id}"]`);
    if (card) {
      const measEl = card.querySelector('.measurement');
      const tsEl   = card.querySelector('.ts');
      measEl.textContent = sd.measurement;
      tsEl.textContent   = new Date(sd.timestamp)
        .toLocaleString('de-DE',{ dateStyle:'short', timeStyle:'short' });
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
