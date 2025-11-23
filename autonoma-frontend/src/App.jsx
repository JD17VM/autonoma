import { BrowserRouter, Route, Routes, useNavigate } from 'react-router-dom';

import Inicio from './Inicio'
import Login from './Login'

function App() {

  return (
    <BrowserRouter>
        <Routes>
          <Route path="/" element={<Inicio />} />
          <Route path="/login" element={<Login />} />
        </Routes>
    </BrowserRouter>
  )
}

export default App