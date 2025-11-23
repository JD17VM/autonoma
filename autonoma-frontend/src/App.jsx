import { useState } from 'react'

function App() {
  return (
    <div style={{ padding: '50px' }}>
      
      {/* =======================================================
          PRUEBA 1: ZONA LIBRE (AFUERA)
          Aquí Bootstrap NO debe existir.
         ======================================================= */}
      <section style={{ marginBottom: '50px', border: '2px solid red', padding: '20px' }}>
        <h2 style={{ color: 'red' }}>ZONA 1: Afuera de la jaula (Tus estilos)</h2>
        
        <p>1. Mira este texto. Debería tener la fuente por defecto (Times New Roman o la que tú definas), NO la de Bootstrap (Arial/Helvetica).</p>
        
        {/* Este botón tiene clases de Bootstrap, pero NO debería verse azul si la jaula funciona */}
        <p>2. El siguiente botón intenta usar Bootstrap, pero debería verse feo/normal:</p>
        <button className="btn btn-primary">
          Soy un impostor (No debo ser azul)
        </button>
      </section>


      {/* =======================================================
          PRUEBA 2: ZONA JAULA (ADENTRO)
          Aquí Bootstrap SÍ debe funcionar.
         ======================================================= */}
      <div className="bootstrap-scope"> {/* <--- AQUÍ ABRES LA JAULA */}
        
        <section style={{ border: '2px solid green', padding: '20px' }}>
          <h2 style={{ color: 'green' }}>ZONA 2: Adentro de la jaula (Bootstrap)</h2>
          
          <p>1. Este texto debería verse con la fuente bonita de Bootstrap (Sans-serif).</p>
          
          <p>2. Este botón SÍ debe ser azul y bonito:</p>
          <button className="btn btn-primary">
            Soy Bootstrap Real (Debo ser azul)
          </button>

          {/* Prueba de tu tabla */}
          <br /><br />
          <table className="table table-dark table-striped mt-3">
            <thead>
              <tr><th>#</th><th>Prueba Tabla</th></tr>
            </thead>
            <tbody>
              <tr><td>1</td><td>Funciona perfecto</td></tr>
            </tbody>
          </table>

        </section>

      </div> {/* <--- AQUÍ CIERRAS LA JAULA */}

    </div>
  )
}

export default App