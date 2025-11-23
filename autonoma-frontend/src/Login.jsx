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
        // Limpiar el mensaje de error si el usuario intenta escribir de nuevo
        if (error) setError(null);
    };

    // Envío del formulario (Lógica de Conexión)
    const handleSubmit = async (e) => {
        e.preventDefault();
        setError(null);
        setIsLoading(true);

        try {
            // URL dinámica desde tu archivo .env.local
            const url = `${import.meta.env.VITE_BASE_URL_API}/api/auth/login`;

            console.log("Conectando a:", url); // Debug

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

            // Si Laravel devuelve error (ej: 401 Credenciales incorrectas)
            if (!response.ok) {
                throw new Error(data.message || 'Error al iniciar sesión');
            }

            // --- Lógica para obtener el Token ---
            // Revisamos si el token viene directo o dentro de "data" (depende de tu ApiResponser)
            const token = data.data?.access_token || data.access_token;
            const user = data.data?.user || data.user;

            if (token) {
                console.log("Login exitoso.");
                
                // Guardamos token y usuario en el navegador
                localStorage.setItem('auth_token', token);
                if (user) {
                    localStorage.setItem('user_data', JSON.stringify(user));
                }

                // Redirigir al inicio
                navigate('/'); 
            } else {
                console.error("Respuesta sin token:", data);
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
        <div className="login-container">
            
            {/* LADO IZQUIERDO: Banner/Imagen */}
            <div className="login-banner-side">
                {/* Aquí irá tu fondo azul mediante CSS después */}
            </div>

            {/* LADO DERECHO: Formulario */}
            <div className="login-form-side">
                <div className="login-content-wrapper">
                    
                    {/* Cabecera */}
                    <div className="login-header">
                        <div className="logo-placeholder">AUTONOMA LOGO</div>
                        <h2>Iniciar sesión</h2>
                    </div>

                    {/* Mensaje de Error (solo visible si falla) */}
                    {error && (
                        <div style={{ color: 'red', margin: '10px 0', textAlign: 'center' }}>
                            {error}
                        </div>
                    )}

                    {/* Formulario */}
                    <form onSubmit={handleSubmit} className="login-form">
                        
                        {/* Input: Email */}
                        <div className="form-group">
                            <label htmlFor="email">Correo</label>
                            <input 
                                type="email" 
                                id="email"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                placeholder="ejemplo@correo.com"
                                required
                                disabled={isLoading}
                            />
                        </div>

                        {/* Input: Contraseña */}
                        <div className="form-group">
                            <label htmlFor="password">Contraseña</label>
                            <div className="password-input-wrapper">
                                <input 
                                    type={showPassword ? "text" : "password"} 
                                    id="password"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                    placeholder="**********"
                                    required
                                    disabled={isLoading}
                                />
                                <button 
                                    type="button" 
                                    onClick={() => setShowPassword(!showPassword)}
                                    disabled={isLoading}
                                    className="toggle-password-btn"
                                >
                                    {showPassword ? "Ocultar" : "Ver"}
                                </button>
                            </div>
                        </div>

                        {/* Opciones: Checkbox y Olvidé contraseña */}
                        <div className="form-actions-row">
                            <label className="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    name="remember"
                                    checked={formData.remember}
                                    onChange={handleChange}
                                    disabled={isLoading}
                                />
                                <span>Recuérdame</span>
                            </label>

                            <Link to="/recuperar" className="forgot-password-link">
                                Olvidé mi contraseña
                            </Link>
                        </div>

                        {/* Botón Submit */}
                        <button type="submit" className="btn-submit" disabled={isLoading}>
                            {isLoading ? 'Ingresando...' : 'Continuar'}
                        </button>

                        {/* Botón Google */}
                        <button type="button" className="btn-google" disabled={isLoading}>
                            Continuar con Google
                        </button>

                    </form>
                </div>
            </div>
        </div>
    );
};

export default Login;