import { useState } from 'react'

// 1. Tu limpieza (Reset)
import './assets/styles/normalize.css'

// 2. Tu configuración SASS híbrida
import './assets/styles/bootstrap-isolation.scss';

// 3. JS para que funcione el clic del modal
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

function App() {
  return (
    <div style={{ padding: '50px' }}>
      
      {/* --- ZONA 1: TU DISEÑO (Fuera de la jaula) --- */}
      <section style={{ marginBottom: '40px' }}>
        <h1 style={{ color: 'red' }}>Prueba 1: Diseño Propio</h1>
        <p>Este texto debe tener tu fuente normal (probablemente Times New Roman o Serif).</p>
        <button className="btn btn-primary">
          Soy un botón sin estilos (No debo ser azul)
        </button>
      </section>

      {/* --- ZONA 2: LA JAULA (Bootstrap activo) --- */}
      <div className="bootstrap-scope">
        
        <section style={{ border: '2px dashed blue', padding: '20px' }}>
          <h2 className="text-primary">Prueba 2: Zona Bootstrap</h2>
          <p>Este texto debe ser Sans-Serif y bonito.</p>

          {/* Botón que activa el Modal */}
          <button 
            type="button" 
            className="btn btn-primary" 
            data-bs-toggle="modal" 
            data-bs-target="#exampleModal"
          >
            ¡Abrir Modal de Prueba!
          </button>

          {/* --- EL MODAL (El código está aquí, pero al abrirse viaja al Body) --- */}
          <div className="modal fade" id="exampleModal" tabIndex="-1" aria-hidden="true">
            <div className="modal-dialog">
              <div className="modal-content">
                <div className="modal-header">
                  <h1 className="modal-title fs-5">Prueba Exitosa</h1>
                  <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div className="modal-body text-dark">
                  Si ves este cuadro blanco con sombras y bordes redondeados... 
                  <strong>¡La configuración funciona!</strong>
                  <br/><br/>
                  El modal se ve bien aunque esté fuera de la jaula .bootstrap-scope.
                </div>
                <div className="modal-footer">
                  <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="button" className="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>

    </div>
  )
}

export default App