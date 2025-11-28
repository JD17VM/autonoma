import { BrowserRouter, Route, Routes, useNavigate } from 'react-router-dom';

import Inicio from './Inicio'
import Login from './Login'
import Navegador from './widgets/PanelNavegacion'
import PiezasConocimiento from './PiezasConocimiento';
import PiezaConocimiento from './PiezaConocimiento';

function App() {

  return (
    <BrowserRouter>
      <Navegador/>
        <Routes>
          <Route path="/" element={<Inicio />} />
          <Route path="/login" element={<Login />} />
          <Route path="/piezas-conocimiento" element={<PiezasConocimiento />} />
          <Route path="/gestion-pieza-conocimiento" element={<PiezaConocimiento />} />
          <Route path="/gestion-pieza-conocimiento/:id" element={<PiezaConocimiento />} />
        </Routes>
    </BrowserRouter>
  )
}

export default App