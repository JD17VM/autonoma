import { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate, Link } from 'react-router-dom';
// Siguraduen a na-install ti react-icons: npm install react-icons
import { MdSave, MdArrowBack } from 'react-icons/md'; 

const PiezaConocimiento = () => {
    const navigate = useNavigate();
    
    // --- ESTADOS ---
    const [canales, setCanales] = useState([]);
    const [etiquetas, setEtiquetas] = useState([]);
    const [loadingData, setLoadingData] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState(null);

    // Formulario
    const [formData, setFormData] = useState({
        titulo: '',
        contenido: '',
        id_canal: '',     
        id_etiqueta: '',  
        activo: true
    });

    // Helpers
    const getToken = () => localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    
    const getUserId = () => {
        const userStr = localStorage.getItem('user_data') || sessionStorage.getItem('user_data');
        if (!userStr) return null;
        try {
            return JSON.parse(userStr).id;
        } catch (e) {
            return null;
        }
    };

    // --- CARGAR DATOS ---
    useEffect(() => {
        const loadResources = async () => {
            const token = getToken();
            if (!token) return;

            try {
                const config = { headers: { 'Authorization': `Bearer ${token}` } };
                
                const [resCanales, resEtiquetas] = await Promise.all([
                    axios.get(`${import.meta.env.VITE_BASE_URL_API}/api/canales`, config),
                    axios.get(`${import.meta.env.VITE_BASE_URL_API}/api/etiquetas`, config)
                ]);

                setCanales(resCanales.data.data);
                setEtiquetas(resEtiquetas.data.data);
                setLoadingData(false);

            } catch (err) {
                console.error("Error cargando recursos:", err);
                setError("No se pudieron cargar los datos necesarios.");
                setLoadingData(false);
            }
        };
        loadResources();
    }, []);

    // --- SUBMIT ---
    const handleSubmit = async (e) => {
        e.preventDefault();
        setSaving(true);
        setError(null);

        const token = getToken();
        const userId = getUserId(); 

        try {
            // Validaciones
            if (!userId) throw new Error("No se pudo identificar al usuario creador. Relogueate.");
            if (!formData.id_canal) throw new Error("Debes seleccionar un canal.");
            if (!formData.titulo) throw new Error("El título es obligatorio.");
            
            // Si hay etiquetas disponibles, mabalin a piliten nga agpili (opsyonal)
            if (etiquetas.length > 0 && !formData.id_etiqueta) {
                 // throw new Error("Debes seleccionar una etiqueta.");
            }

            const url = `${import.meta.env.VITE_BASE_URL_API}/api/piezas`;
            
            // Preparamos el payload
            const payload = {
                ...formData,
                creado_por: userId, // 👈 Importante: Ipadala ti ID tapno dawat ti backend
                puntaje_relevancia: 0,
                id_etiqueta: formData.id_etiqueta || null 
            };

            // 👇 KORREKSION: Usaren ti variable nga 'payload' imbes nga baro nga object
            await axios.post(url, payload, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            navigate('/informacion');

        } catch (err) {
            console.error(err);
            const msg = err.response?.data?.message || err.message || "Error al guardar.";
            setError(msg);
            setSaving(false);
        }
    };

    if (loadingData) return <div className="p-5 text-center">Cargando formulario...</div>;

    return (
        <div className="bootstrap-scope p-4 bg-light min-vh-100">
            <form onSubmit={handleSubmit}>
                
                {/* HEADER */}
                <div className="d-flex justify-content-between align-items-center mb-4">
                    <div className="d-flex align-items-center gap-3">
                        <Link to="/informacion" className="btn btn-outline-secondary btn-sm rounded-circle p-2 d-flex align-items-center justify-content-center" style={{width:40, height:40}}>
                            <MdArrowBack size={24} />
                        </Link>
                        <div>
                            <h2 className="mb-0 fw-bold text-primary">Crear Pieza</h2>
                            <div className="form-check form-switch mt-1">
                                <input 
                                    className="form-check-input" 
                                    type="checkbox" 
                                    checked={formData.activo}
                                    onChange={(e) => setFormData({...formData, activo: e.target.checked})}
                                />
                                <label className="form-check-label small text-muted">
                                    {formData.activo ? 'Activo' : 'Inactivo'}
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" className="btn btn-primary px-4 fw-bold d-flex align-items-center gap-2" disabled={saving}>
                        {saving ? 'Guardando...' : <><MdSave size={20}/> Guardar</>}
                    </button>
                </div>

                {error && <div className="alert alert-danger mb-4">{error}</div>}

                {/* CANALES */}
                <div className="card shadow-sm border-0 mb-4">
                    <div className="card-body">
                        <label className="form-label fw-bold mb-3">Canal asignado</label>
                        <div className="d-flex flex-wrap gap-3">
                            {canales.length > 0 ? canales.map(canal => (
                                <div 
                                    key={canal.id}
                                    onClick={() => setFormData({...formData, id_canal: canal.id})}
                                    className={`
                                        border rounded p-2 px-3 cursor-pointer d-flex align-items-center gap-2 transition-all
                                        ${formData.id_canal === canal.id ? 'border-primary bg-primary text-white shadow' : 'bg-white text-muted hover-shadow'}
                                    `}
                                    style={{ cursor: 'pointer', minWidth: '150px' }}
                                >
                                    <span>💬</span>
                                    <span className="fw-medium small">{canal.titulo}</span>
                                </div>
                            )) : (
                                <div className="text-muted fst-italic small">
                                    ⚠️ No hay canales. <br/>
                                    Debes crear un canal en la base de datos primero (o usar el Seeder).
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* CONTENIDO */}
                <div className="card shadow-sm border-0 mb-4">
                    <div className="card-body">
                        <div className="mb-4">
                            <label className="form-label fw-bold">Título</label>
                            <input 
                                type="text" 
                                className="form-control form-control-lg" 
                                placeholder="Ej. Horarios de atención"
                                value={formData.titulo}
                                onChange={(e) => setFormData({...formData, titulo: e.target.value})}
                            />
                        </div>

                        <div className="mb-2">
                            <label className="form-label fw-bold">Contenido</label>
                            <textarea 
                                className="form-control p-3" 
                                rows="6"
                                placeholder="Escribe la respuesta..."
                                value={formData.contenido}
                                onChange={(e) => setFormData({...formData, contenido: e.target.value})}
                            ></textarea>
                        </div>
                    </div>
                </div>

                {/* ETIQUETAS */}
                <div className="card shadow-sm border-0">
                    <div className="card-body">
                        <label className="form-label fw-bold mb-3">Etiqueta</label>
                        
                        {etiquetas.length > 0 ? (
                            <div className="d-flex flex-wrap gap-2">
                                {etiquetas.map(tag => (
                                    <span 
                                        key={tag.id}
                                        onClick={() => setFormData({...formData, id_etiqueta: tag.id})}
                                        className={`
                                            badge rounded-pill px-3 py-2 cursor-pointer border
                                            ${formData.id_etiqueta === tag.id ? 'bg-success text-white' : 'bg-light text-dark border'}
                                        `}
                                        style={{ cursor: 'pointer' }}
                                    >
                                        {tag.nombre}
                                    </span>
                                ))}
                            </div>
                        ) : (
                            <div className="alert alert-light border mb-0 text-muted small">
                                ℹ️ No hay etiquetas creadas. Se guardará sin etiqueta.
                            </div>
                        )}
                    </div>
                </div>

            </form>
        </div>
    );
};

export default PiezaConocimiento;