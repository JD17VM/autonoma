import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';

const Login = () => {
    const navigate = useNavigate();

    // Estado para los datos del formulario
    const [formData, setFormData] = useState({
        email: '',
        password: '',
        remember: false
    });

    // Estados para la interfaz (UI)
    const [showPassword, setShowPassword] = useState(false);
    const [error, setError] = useState(null);
    const [isLoading, setIsLoading] = useState(false);

    // Maneja los cambios en los inputs
    const handleChange = (e) => {
        const { name, value, type, checked } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value
        }));
        if (error) setError(null);
    };

    // Envío del formulario
    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        setIsLoading(true);

        try {
            // URL dinámica desde .env.local
            const url = `${import.meta.env.VITE_BASE_URL_API}/api/auth/login`;
            console.log("Conectando a:", url); 

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({
                    email: formData.email,
                    password: formData.password
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Error al iniciar sesión');
            }

            // Obtener Token
            const token = data.data?.access_token || data.access_token;
            const user = data.data?.user || data.user;

            if (token) {
                // ⭐ MODIFICACIÓN CLAVE: Seleccionar el storage según 'remember'
                const storage = formData.remember ? localStorage : sessionStorage;

                // 1. Limpiar el otro storage por si acaso (ej: si antes marcó recordar y ahora no)
                if (formData.remember) {
                    sessionStorage.removeItem('auth_token');
                    sessionStorage.removeItem('user_data');
                } else {
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user_data');
                }
                
                // 2. Guardar en el storage seleccionado
                storage.setItem('auth_token', token);

                if (user) {
                    storage.setItem('user_data', JSON.stringify(user));
                }

                // Redirigir al inicio
                navigate('/');
            } else {
                throw new Error("No se recibió el token de acceso.");
            }

        } catch (err) {
            console.error("Error en login:", err);
            setError(err.message || "Error de conexión con el servidor");
        } finally {
            setIsLoading(false);
        }
    };

    return (
        /* 1. ABRIMOS LA JAULA (.bootstrap-scope) para que funcionen los estilos aquí dentro.
           2. Usamos 'vh-100' para que ocupe toda la altura de la pantalla.
           3. Usamos 'bg-light' para un fondo gris suave general.
        */
        <div className="bootstrap-scope vh-100 bg-light">
            
            <div className="container-fluid h-100">
                <div className="row h-100">
                    
                    {/* --- LADO IZQUIERDO: Banner Azul --- */}
                    {/* d-none d-md-block: Se oculta en celulares, se ve en pantallas medianas para arriba */}
                    <div className="col-md-6 col-lg-7 bg-primary d-flex align-items-center justify-content-center text-white">
                        <div className="text-center p-5">
                            <h1 className="display-4 fw-bold">Bienvenido a Autonoma</h1>
                            <p className="lead">Gestión inteligente para tu negocio.</p>
                            {/* Aquí podrías poner una etiqueta <img /> grande si quisieras */}
                        </div>
                    </div>

                    {/* --- LADO DERECHO: Formulario --- */}
                    <div className="col-md-6 col-lg-5 d-flex align-items-center justify-content-center bg-white">
                        <div className="w-75" style={{ maxWidth: '400px' }}>
                            
                            {/* Cabecera */}
                            <div className="text-center mb-5">
                                <h4 className="fw-bold text-primary mb-2">AUTONOMA</h4>
                                <h2 className="fw-bold">Iniciar sesión</h2>
                            </div>

                            {/* Alerta de Error */}
                            {error && (
                                <div className="alert alert-danger text-center p-2 mb-4" role="alert">
                                    <small>{error}</small>
                                </div>
                            )}

                            {/* Formulario */}
                            <form onSubmit={handleSubmit}>
                                
                                {/* Email */}
                                <div className="mb-3">
                                    <label htmlFor="email" className="form-label fw-bold small">Correo</label>
                                    <input 
                                        type="email" 
                                        className="form-control form-control-lg bg-light"
                                        id="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleChange}
                                        placeholder="ejemplo@correo.com"
                                        required
                                        disabled={isLoading}
                                    />
                                </div>

                                {/* Contraseña con Input Group para el botón "Ver" */}
                                <div className="mb-4">
                                    <label htmlFor="password" class="form-label fw-bold small">Contraseña</label>
                                    <div className="input-group">
                                        <input 
                                            type={showPassword ? "text" : "password"} 
                                            className="form-control form-control-lg bg-light border-end-0"
                                            id="password"
                                            name="password"
                                            value={formData.password}
                                            onChange={handleChange}
                                            placeholder="**********"
                                            required
                                            disabled={isLoading}
                                        />
                                        <button 
                                            className="btn btn-light border border-start-0 text-muted" 
                                            type="button"
                                            onClick={() => setShowPassword(!showPassword)}
                                            disabled={isLoading}
                                        >
                                            {showPassword ? "Ocultar" : "Ver"}
                                        </button>
                                    </div>
                                </div>

                                {/* Opciones: Checkbox y Link */}
                                <div className="d-flex justify-content-between align-items-center mb-4">
                                    <div className="form-check">
                                        <input 
                                            className="form-check-input" 
                                            type="checkbox" 
                                            name="remember"
                                            id="remember"
                                            checked={formData.remember}
                                            onChange={handleChange}
                                            disabled={isLoading}
                                        />
                                        <label className="form-check-label small" htmlFor="remember">
                                            Recuérdame
                                        </label>
                                    </div>
                                    <Link to="/recuperar" className="text-decoration-none small text-dark fw-bold">
                                        Olvidé mi contraseña
                                    </Link>
                                </div>

                                {/* Botón Submit (Verde como tu diseño) */}
                                <button type="submit" className="btn btn-success w-100 py-2 fw-bold mb-3" disabled={isLoading}>
                                    {isLoading ? (
                                        <span>
                                            <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Ingresando...
                                        </span>
                                    ) : 'Continuar'}
                                </button>

                                {/* Botón Google */}
                                <button type="button" className="btn btn-outline-dark w-100 py-2 fw-bold" disabled={isLoading}>
                                    <span className="me-2">G</span> Continuar con Google
                                </button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    );
};

export default Login;