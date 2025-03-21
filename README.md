# MEDICITAS
ALUMNO: TOMY JOSE MONTUFAR ZUNIGA (202310050054)
HERRAMIENTAS USADAS: PHP, HTML, CSS, SQL SERVER, VISUAL STUDIO CODE

--- 01/02/2025 ---
Se empieza a crear el diseño de las interfaces de inicio y el módulo de autenticación, donde comienza los primeros pilares del sistema.

Dentro del módulo de autenticación se desarrolla el diseño para el registro de usuario en el sistema Medicitas.

--- 07/02/2025 ---
Luego de crear el diseño se agrega funcionalidad al formulario de registro, donde permite registrar el usuario con la información básica que solicita.

--- 8/02/2025 ---
Se agrega la funcionalidad para que el formulario de registro maneje mediante eventos de cambio de rol la visibilidad de campos adicionales según los parámetros requeridos por las tablas Médicos o Pacientes.

Luego se corrigen errores en la interfaz de inicio que impedian se visualizara correctamente la barra de menu.

--- 15/02/2025 ---
Se ordena los archivos en jerarquía para una mejor organización del código fuente dando una visibilidad y ubicación más limpia, también se hizo corrección de errores y ajustes en el diseño de la interfaz.

-- 17/02/2025 ---
Agregamos librerias externas para poder generar reportes y descargarlos en el dispositivo, en formato de pdf, excel, word.

--- 18/02/2025 ---
Se desarrolla el primer diseño para la interfaz del administrador, donde el usuario podría trabajar con la mayoría de funciones del sistema. También se añaden las primeras tablas en los módulos para poder mostrar la información de los usuarios.

Más tarde el diseño del menú sería reemplazado por uno más elegante y apropiado para manejar las secciones de trabajo y la tabla manejaría una sola paleta de colores.

--- 19/02/2025 ---
Se agrega funcionalidad a las tablas de Usuarios, Medicos y Pacientes donde únicamente muestra la información contenida en la base de datos.

--- 21/02/2025 ---
Agregamos las primeras ventanas modales que sirven para poder abrir los formularios sin tener que recargar la pagina o dirigir a una pestaña aparte. 

Aquí se implementa el manejo de sesiones para evitar que se pueda acceder a los archivos internos si no se ha autenticado desde el login.

--- 24/02/2025 ---
Se corrigen algunos errores que afectaban el funcionamiento de las ventanas modales y se mejoran algunas funcionalidades.

--- 27/02/2025 ---
Se corrigen algunos errores visuales en el diseño del sistema y se agregan funciones de editar, eliminar y agregar para la sección de Médicos en Administrador.

--- 02/03/2025 ---
Se agrega funcionalidades de editar, agregar y eliminar para la sección de Pacientes en Administrador.

--- 05/03/2025 ---
Se agrega la tabla de Citas Medicas y se implementan funciones para seleccionar el Paciente y Medico de forma dinamica en los formularios modales para Editar y Agregar-

--- 06/03/2025 ---
Se desarrolla el diseño y funcionalidad a la tabla de Especialidades para la sección del mismo nombre en Administrador.

--- 07/03/2025 ---
Se agrega todas las tablas del sistema una mecánica de actualización dinámica/automática mediante eventos de teclado y cambio de selección, sin necesidad de recargar la página.

--- 15/03/2025 ---
Se trabaja la sección de Horarios Médicos en la interfaz del Médico donde se agregan funcionalidades de navegar entre el calendario, y asignar cupos en las diferentes fechas por Médico asignado.

Contiene funciones de agregar, eliminar y editar los diferentes horarios médicos.

--- 20/03/2025 ---
De la misma forma para el modulo del Administrador se copia la misma estructura y funcionalidad de la seccion de Horarios para que el administrador pueda agregar/editar/eliminar los horarios asignados en el sistema.

Luego se agrega los complementos para la Agregar/Editar/Eliminar Documentos Medicos en el modulo del Medico, donde muestra una tabla listando los documentos medicos en el sistema.