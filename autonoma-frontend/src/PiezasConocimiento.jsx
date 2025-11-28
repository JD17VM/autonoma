import { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const PiezasConocimiento = () => {
    const [piezas, setPiezas] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    // 1. RECUPERAR EL TOKEN CORRECTAMENTE
    // Buscamos en ambos almacenamientos y usamos la clave correcta 'auth_token'
    const getToken = () => {
        return localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    };

    useEffect(() => {
        const fetchPiezas = async () => {
            const token = getToken();

            if (!token) {
                setError("No hay sesión activa. Por favor inicia sesión.");
                setLoading(false);
                return;
            }

            try {
                // Usamos la variable de entorno para la URL
                const url = `${import.meta.env.VITE_BASE_URL_API}/api/piezas`;
                
                const response = await axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`, // Enviamos el token en la cabecera
                        'Accept': 'application/json'
                    }
                });

                // La API devuelve { success: true, data: [...] }
                setPiezas(response.data.data);
                setLoading(false);

            } catch (err) {
                console.error("Error fetching piezas:", err);
                if (err.response && err.response.status === 401) {
                    setError("Tu sesión ha expirado. Por favor ingresa nuevamente.");
                } else {
                    setError("Error al cargar los datos del servidor.");
                }
                setLoading(false);
            }
        };

        fetchPiezas();
    }, []);

    // Renderizado condicional para estados de carga/error
    if (loading) return <div className="p-5 text-center">Cargando contenido...</div>;
    
    if (error) return (
        <div className="p-5 text-center">
            <div className="alert alert-danger">{error}</div>
            <Link to="/login" className="btn btn-primary">Ir al Login</Link>
        </div>
    );

    return (
        <div className="bootstrap-scope p-4">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="mb-0">Piezas de conocimiento</h2>
                <Link to="/gestion-pieza-conocimiento" className="btn btn-primary">
                    + Crear nueva pieza de conocimiento
                </Link>
            </div>

            {/* Barra de búsqueda simple (visual por ahora) */}
            <div className="row mb-3">
                <div className="col-md-6">
                    <input type="text" className="form-control" placeholder="Buscar por título o palabra clave" />
                </div>
            </div>

            <div className="card shadow-sm border-0">
                <div className="table-responsive">
                    <table className="table table-hover align-middle mb-0">
                        <thead className="table-light">
                            <tr>
                                <th scope="col" className="ps-4">Título</th>
                                <th scope="col">Etiqueta</th>
                                <th scope="col">Canal (ID)</th>
                                <th scope="col">Última Actualiz.</th>
                                <th scope="col">Estado</th>
                                <th scope="col" className="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {piezas.length > 0 ? (
                                piezas.map((pieza) => (
                                    <tr key={pieza.id}>
                                        {/* Título */}
                                        <td className="ps-4 fw-bold text-dark">
                                            {pieza.titulo}
                                        </td>

                                        {/* Etiqueta */}
                                        <td>
                                            {pieza.etiqueta ? (
                                                <span className="badge rounded-pill bg-light text-dark border">
                                                    {pieza.etiqueta.nombre}
                                                </span>
                                            ) : (
                                                <span className="text-muted small fst-italic">Sin etiqueta</span>
                                            )}
                                        </td>

                                        {/* Canales (Mostramos Nombre e ID como pediste) */}
                                        <td>
                                            {pieza.canal ? (
                                                <div className="d-flex align-items-center">
                                                    {/* Si el backend tuviera logo_url lo pondríamos aquí */}
                                                    <div>
                                                        <span className="d-block lh-1">{pieza.canal.titulo}</span>
                                                        <small className="text-muted" style={{ fontSize: '0.75rem' }}>
                                                            ID: {pieza.canal.id}
                                                        </small>
                                                    </div>
                                                </div>
                                            ) : (
                                                <span className="text-muted">-</span>
                                            )}
                                        </td>

                                        {/* Última Actualización */}
                                        <td className="text-muted">
                                            {new Date(pieza.updated_at).toLocaleDateString('es-ES', {
                                                day: 'numeric', month: 'short'
                                            })}
                                        </td>

                                        {/* Estado (Activo/Inactivo) */}
                                        <td>
                                            {pieza.activo ? (
                                                <div className="d-flex align-items-center text-success small fw-bold">
                                                    <span className="bg-success rounded-circle me-2" style={{width:'8px', height:'8px'}}></span>
                                                    Activo
                                                </div>
                                            ) : (
                                                <div className="d-flex align-items-center text-danger small fw-bold">
                                                    <span className="bg-danger rounded-circle me-2" style={{width:'8px', height:'8px'}}></span>
                                                    Inactivo
                                                </div>
                                            )}
                                        </td>

                                        {/* Acciones */}
                                        <td className="text-end pe-4">
                                            <button className="btn btn-link text-secondary p-0 text-decoration-none">
                                                ✏️
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="6" className="text-center p-4 text-muted">
                                        No se encontraron resultados
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
            
            {/* Paginación simple visual */}
            <div className="d-flex justify-content-between align-items-center mt-3 text-muted small">
                <span>{piezas.length} resultados</span>
                <nav>
                    <ul className="pagination pagination-sm mb-0">
                        <li className="page-item disabled"><a className="page-link" href="#">‹</a></li>
                        <li className="page-item active"><a className="page-link" href="#">1</a></li>
                        <li className="page-item"><a className="page-link" href="#">2</a></li>
                        <li className="page-item"><a className="page-link" href="#">3</a></li>
                        <li className="page-item"><a className="page-link" href="#">›</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    );
};

export default PiezasConocimiento;