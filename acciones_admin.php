:root {
    --p-rosa: #ff4d8d;
    --p-morado: #7b2cbf;
    --glass: rgba(255, 255, 255, 0.9);
    --texto: #4a148c;
}

body {
    background: linear-gradient(135deg, #fce4ec 0%, #f3e5f5 100%);
    font-family: 'Segoe UI', sans-serif;
    color: var(--texto);
    margin: 0;
    display: flex;
    justify-content: center;
    padding: 20px;
}

.contenedor {
    max-width: 900px;
    width: 100%;
}

.card-prediccion {
    background: var(--glass);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    border: 1px solid white;
}

.input-moderno {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #e1bee7;
    margin: 10px 0;
    font-size: 16px;
}

.btn-generar {
    background: var(--p-rosa);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: bold;
    width: 100%;
}

.calendario-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
    background: white;
    padding: 15px;
    border-radius: 20px;
}

.dia-nombre {
    text-align: center;
    font-size: 12px;
    font-weight: bold;
    color: #999;
}

.dia-caja {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 14px;
    transition: 0.3s;
}

.periodo-estimado {
    background-color: var(--p-rosa) !important;
    color: white !important;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(255, 77, 141, 0.4);
}

.hoy {
    border: 2px solid var(--p-morado);
}

.mes-titulo {
    text-align: center;
    margin: 20px 0;
    color: var(--p-morado);
}