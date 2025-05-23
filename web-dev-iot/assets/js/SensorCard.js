// assets/js/SensorCard.js
export class SensorCard {
  constructor(sensor) {
    this.sensor = sensor;
  }

  render() {
    // Spaltendiv für Bootstrap-Grid
    const col = document.createElement('div');
    col.className = 'col-6 col-md-4 col-lg-3';

    // Card-Container
    const card = document.createElement('div');
    card.className = 'card h-100 shadow-sm';

    // Zeitstempel formatieren oder Platzhalter
    const ts = this.sensor.last_timestamp
      ? new Date(this.sensor.last_timestamp)
          .toLocaleString('de-DE', { dateStyle: 'short', timeStyle: 'short' })
      : '—';

    // Card-Inhalt mit deutschem Text und Einheiten
    card.innerHTML = `
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">${this.sensor.type}</h5>
        <p class="mb-1"><strong>ID:</strong> ${this.sensor.id}</p>
        <p class="mb-1"><strong>Temperatur:</strong> ${this.sensor.last_temperature ?? '—'} °C</p>
        <p class="mb-3"><strong>Luftfeuchte:</strong> ${this.sensor.last_humidity ?? '—'} %</p>
        <small class="mt-auto text-muted">${ts}</small>
        <button class="btn btn-danger mt-3">Entfernen</button>
      </div>
    `;

    // Löschen-Button anklickbar machen
    const btn = card.querySelector('button');
    btn.addEventListener('click', async () => {
      const confirmMsg = 
        'Soll der Sensor wirklich gelöscht werden?\n' +
        'Alle zugehörigen Sensordaten werden dabei entfernt.';
      if (!confirm(confirmMsg)) return;

      // DELETE-Request an Backend
      const res = await fetch(`/api/sensors/${this.sensor.id}`, {
        method: 'DELETE'
      });

      if (res.ok) {
        // “loadSensors” und “loadData” muss man in main.js als global verfügbar machen
        window.loadSensors();
        window.loadData();
      } else {
        alert('Löschen fehlgeschlagen!');
      }
    });

    col.appendChild(card);
    return col;
  }
}
