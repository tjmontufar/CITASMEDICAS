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

--- 22/03/2025 ---
Se agregan los complementos para el modulo de pacientes y se corrigen problemas de insercion en citas medicas para Administrador o Medico en el sistema.
Se implementa actualizacion dinamica sin recargar a la tabla de pacientes en el modulo de Medicos.

Se hace una importante modificacion en el formulario de modalAgregarCita donde se puede buscar el paciente escribiendo el nombre y el medico se puede asignar buscando en la fecha seleccionada, lo cual hace más facil la búsqueda y asignación. Se corrige un problema al mostrar el total de cupos del horario.

--- 23/03/2025 ---
Se actualiza la logica de la ventana modalEditarCita usando los mismos ajustes que en modalAgregarCita para buscar el paciente y medico de una forma más rápida y fácil de asignar, se corrigen errores al momento de editar la cita.
Se corrige un error en la busqueda de pacientes en modalAgregarCita que impedia sugerir los pacientes disponibles.

--- 24/03/2025 ---
Se agrega una mejora en la asignacion de horarios medicos donde se puede obtener sugerencias de medicos existentes en la base de datos del sistema para una busqueda mas rapida y facil de hacer.
Se implementan las mismas actualizaciones en Médicos para las secciones de Horarios y Citas Médicas como en Administrador.
Se mejora la logica de la seccion de Documentos medicos y se actualiza el modalAgregarDocumento para poder seleccionar las citas registradas de forma mas facil y rapida, se agrega actualizacion dinamica a la tabla de documentos medicos.

--- 26/03/2025 ---
Se hacen cambios en la modalEditarDocumentos en la seccion de Documentos Medicos para poder actualizar la información en base a los cambios realizados en modalAgregarDocumentos y se corrige un error que autorrellenaba la misma formación de paciente y medico en la modalAgregarDocumentos desde presionar editar.
Se implementa una mejora en los botones de la tablas que cambian su color a uno mas llamativo al momento de colocar el cursor sobre él.

--- 27/03/2025 ---
Se implementa la funcionalidad en la seccion Documentos Medicos para generar reportes pdf que contiene las Recetas y Constancias medicas en una plantilla minimalista y facil de leer.
Se corrige un error que permitia insercion de duplicados de numeros de Licencias y telefonos al registrar/editar medicos en Administrador.
Se actualiza el formulario de registro de usuarios y de pacientes donde verifica si el paciente es un niño o menor de edad, el formulario se adapta para registrar unicamente la información del niño y de los tutores.

--- 30/03/2025 ---
Se actualiza el formulario de registros de usuario donde se completa la funcionalidad que permite registrar un paciente menor de edad y permite también verificar/actualizar los datos del paciente menor de edad en el sistema. Se corrige un error que permitía registrar pacientes mayores de edad con una edad menor a 18 años y viceversa.
Se corrige un error que creaba duplicados de registros de Usuarios mientras se inserta un paciente infantil.

--- 01/04/2025 ---
Se desarrolla la tabla de financiamientos que muestra los pagos realizados en el sistema, se crea la funcion de agregar Pagos en el sistema.

--- 04/04/2025 ---
Se desarrolla en el modulo de pacientes la seccion para la reserva de citas, donde se implementan las primeras secciones de codigo necesarias para la insercion de reserva de citas, todavia en desarrollo.
Se corrigen algunos errores que impedian el funcionamiento correcto para verificar la disponibilidad del horario medico y al Insertar Citas, incluye correccion de algunas consultas y parametros mal definidos.