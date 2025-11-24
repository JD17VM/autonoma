import { useEffect, useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Inicio = () => {
    const navigate = useNavigate();
    const [user, setUser] = useState(null);
    const [storageType, setStorageType] = useState(''); 

    // Al cargar el componente, buscamos si hay datos guardados
    useEffect(() => {
        let storedUser = localStorage.getItem('user_data');
        let token = localStorage.getItem('auth_token');
        let type = 'LocalStorage';

        if (!storedUser || !token) {
            storedUser = sessionStorage.getItem('user_data');
            token = sessionStorage.getItem('auth_token');
            type = 'SessionStorage';
        }

        if (storedUser && token) {
            setUser(JSON.parse(storedUser));
            setStorageType(type); // Guardamos "LocalStorage" o "SessionStorage"
        }
    }, []);

    const handleLogout = () => {
        // Borramos los datos del navegador
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_data');
        sessionStorage.removeItem('auth_token');
        sessionStorage.removeItem('user_data');
        setUser(null);
        setStorageType('');
        navigate('/login'); // Te manda de vuelta al login
    };

    return (
        <div style={{ padding: '40px' }}>
            
            {/* Título general con tus estilos propios (Normalize) */}
            <h1>Página de Inicio - Autonoma</h1>

            {/* ZONA BOOTSTRAP (La Jaula) */}
            <div className="bootstrap-scope">
                
                {user ? (
                    /* CASO 1: USUARIO LOGUEADO */
                    <div className="card shadow-sm" style={{ maxWidth: '600px' }}>
                        <div className="card-header bg-primary text-white">
                            <h5 className="mb-0">¡Sesión Iniciada Correctamente!</h5>
                        </div>
                        <div className="card-body">
                            <h4 className="card-title">Hola, {user.nombre_completo}</h4>
                            <p className="card-text text-muted">Has ingresado al sistema exitosamente.</p>
                            
                            <hr />
                            
                            {/* Datos técnicos para que verifiques */}
                            <h6>Tus Datos (Desde {storageType}):</h6>
                            <ul className="list-group list-group-flush mb-3">
                                <li className="list-group-item"><strong>Email:</strong> {user.email}</li>
                                <li className="list-group-item"><strong>Rol ID:</strong> {user.id_rol}</li>
                                <li className="list-group-item"><strong>Empresa ID:</strong> {user.id_empresa}</li>
                                <li className="list-group-item">
                                    <strong>Estado:</strong> 
                                    {user.activo ? 
                                        <span className="badge bg-success ms-2">Activo</span> : 
                                        <span className="badge bg-danger ms-2">Inactivo</span>
                                    }
                                </li>
                            </ul>

                            <button onClick={handleLogout} className="btn btn-outline-danger w-100">
                                Cerrar Sesión
                            </button>
                        </div>
                    </div>
                ) : (
                    /* CASO 2: NO LOGUEADO */
                    <div className="alert alert-warning" role="alert">
                        <h4 className="alert-heading">No has iniciado sesión</h4>
                        <p>No se encontraron credenciales de usuario.</p>
                        <hr />
                        <div className="d-flex justify-content-end">
                            <Link to="/login" className="btn btn-primary">Ir al Login</Link>
                        </div>
                    </div>
                )}

            </div>
        </div>
    );
};

export default Inicio;