// assets/js/SensorTable.js
export class SensorTable {
  constructor(data) {
    this.data = data;
    this.sortKey = 'timestamp';
    this.sortOrder = 'desc';
    this.query = '';
  }

  // Sortiert nach Spalten-Key
  sortBy(key) {
    if (this.sortKey === key) {
      this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortKey = key;
      this.sortOrder = 'desc';
    }
    this.render();
  }

  // Setzt Such-Query und rendert neu
  filter(q) {
    this.query = q.toLowerCase();
    this.render();
  }

  // Baut Tabelle auf Grundlage der Spalten-Definitionen
  render() {
    // Spalten mit key und Label
    const cols = [
      { key: 'id',           label: 'ID' },
      { key: 'sensor_id',    label: 'Sensor-ID' },
      { key: 'sensor_type',  label: 'Sensortyp' },
      { key: 'temperature',  label: 'Temperatur (°C)' },
      { key: 'humidity',     label: 'Luftfeuchte (%)' },
      { key: 'timestamp',    label: 'Zeitstempel' }
    ];

    const table = document.createElement('table');
    table.className = 'table table-striped table-hover';

    // Header erstellen
    const thead = document.createElement('thead');
    const hr = document.createElement('tr');
    cols.forEach(({ key, label }) => {
      const th = document.createElement('th');
      th.textContent = label;
      th.style.cursor = 'pointer';
      th.onclick = () => this.sortBy(key);
      hr.appendChild(th);
    });
    thead.appendChild(hr);
    table.appendChild(thead);

    // Body erstellen
    const tbody = document.createElement('tbody');
    this._getRows(cols.map(c => c.key)).forEach(rowData => {
      const tr = document.createElement('tr');
      cols.forEach(({ key }) => {
        const td = document.createElement('td');
        td.textContent = rowData[key];
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);

    // Tabelle in Container einfügen
    const container = document.getElementById('data-table');
    container.innerHTML = '';
    container.appendChild(table);
  }

  // Interne Methode zum Sortieren und Filtern
  _getRows(keys) {
    let rows = [...this.data];
    // Sortierung
    rows.sort((a, b) => {
      if (a[this.sortKey] < b[this.sortKey]) return this.sortOrder === 'asc' ? -1 : 1;
      if (a[this.sortKey] > b[this.sortKey]) return this.sortOrder === 'asc' ? 1 : -1;
      return 0;
    });
    // Filter
    if (this.query) {
      rows = rows.filter(r =>
        keys.some(key => String(r[key]).toLowerCase().includes(this.query))
      );
    }
    return rows;
  }
}