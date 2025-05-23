// assets/js/main.js
import { SensorCard } from './SensorCard.js';
import { SensorTable } from './SensorTable.js';

const cardsEl  = document.getElementById('sensor-cards');
const form     = document.getElementById('data-form');
const search   = document.getElementById('search');
let tableInstance;

// 1) Top‐level declarations
async function loadSensors() {
  const res = await fetch('/api/sensors');
  const sensors = await res.json();
  cardsEl.innerHTML = '';
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
      temperature: fd.get('temperature'),
      humidity:    fd.get('humidity'),
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
});
