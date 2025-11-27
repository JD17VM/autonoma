import { Link, useLocation } from 'react-router-dom';

const dataPaginas = {
    data: [
        { 
            nombre: "Inicio", 
            enlace: "/"
        },
        { 
            nombre: "Información", 
            enlace: "/informacion"
        },
        { 
            nombre: "Plantillas", 
            enlace: "/plantillas"
        },
    ]
};


const PanelNavegacion = () => {

    const location = useLocation(); 

    return (
        <nav>
            <ul>
                {dataPaginas.data.map((seccion, index) => (
                    <li key={index}>
                        <Link 
                            to={seccion.enlace}
                        >
                            {seccion.nombre} 
                            {location.pathname === seccion.enlace && ' (Activo)'}
                        </Link>
                    </li>
                ))}
            </ul>
        </nav>
    );
}

export default PanelNavegacion;