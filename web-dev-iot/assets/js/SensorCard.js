export class SensorCard {
  constructor(sensor) {
    this.sensor = sensor;
  }

  render() {
    const col = document.createElement('div');
    col.className = 'col-6 col-md-4 col-lg-3';

    const card = document.createElement('div');
    card.className = 'card h-100 shadow-sm';

    // Letzten Zeitstempel formatieren oder Platzhalter
    const ts = this.sensor.last_timestamp
      ? new Date(this.sensor.last_timestamp)
          .toLocaleString('de-DE', { dateStyle:'short', timeStyle:'short' })
      : '—';
    
    card.innerHTML = `
      <div class="card sensor-card" data-id="${this.sensor.id}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">${this.sensor.type}</h5>
          <p class="mb-1"><strong>ID:</strong> ${this.sensor.id}</p>
          <p class="mb-1">
            <strong>Messung:</strong>
            <span class="measurement">
              ${this.sensor.last_measurement ?? '—'}
            </span>
            <span class="unit">
               (${this.sensor.unit ?? '—'})
            </span>
          </p>
          <small class="mt-auto text-muted ts">
            ${ts}
          </small>
          <button class="btn btn-danger mt-3">Entfernen</button>
        </div>
      </div>
    `;

    // Entfernen-Button behavior
    const btn = card.querySelector('button');
    btn.addEventListener('click', async () => {
      if (!confirm(
        'Soll der Sensor wirklich gelöscht werden?\nAlle zugehörigen Messdaten werden dabei entfernt.'
      )) return;

      const res = await fetch(`/api/sensors/${this.sensor.id}`, { method:'DELETE' });
      if (res.ok) {
        await window.loadSensors();
        await window.loadData();
      } else {
        alert('Löschen fehlgeschlagen!');
      }
    });

    col.appendChild(card);
    return col;
  }
}
