# SegundaJugada-POO

¡Bienvenido/a a **SegundaJugada-POO**!  
Este proyecto es una **página de compraventa de segunda mano especializada en productos de baloncesto**. Aquí los usuarios pueden comprar y vender artículos deportivos de baloncesto, encontrar productos populares, destacados y mucho más, todo en un entorno web atractivo y funcional.

---

## ¿De qué trata el proyecto?

SegundaJugada-POO es una plataforma web orientada a la compraventa de productos de baloncesto de segunda mano.  
Permite a los usuarios:
- Publicar anuncios de productos **(no disponible por el momento)**.
- Buscar, filtrar y visualizar artículos.
- Acceder a productos destacados, populares y con mejor valoración.
- Iniciar sesión tanto como usuario local, usuario de google <img style="width:2%;" src="https://brandlogos.net/wp-content/uploads/2025/05/google_icon_2025-logo_brandlogos.net_qm5ka-512x523.png">, o usuario de gitbub <img style="width:2.7%;" src="https://www.pngmart.com/files/23/Github-Logo-PNG.png">.

---

## ⚙️ Tecnologías utilizadas

El proyecto divide claramente las tecnologías entre **Frontend** y **Backend** y usa tecnolgía de **POO** ***(programación orientada a objetos)***.

---

### ✨ Frontend

<table>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" width="60" alt="JavaScript"/><br/>
      <b>JavaScript</b>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/jquery/jquery-original.svg" width="60" alt="jQuery"/><br/>
      <b>jQuery</b>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" width="60" alt="HTML5"/><br/>
      <b>HTML5</b>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" width="60" alt="CSS3"/><br/>
      <b>CSS3</b>
    </td>
  </tr>
</table>

**Librerías y plugins destacados**:
- **Owl Carousel**: Carruseles de productos.
- **SweetAlert2**: Alertas y modales bonitos.
- **jQuery UI**: Componentes de interfaz avanzada.
- **FontAwesome**: Iconografía.
- **Toastr**: Notificaciones emergentes.

---

### 🛢️ Backend

<table>
  <tr>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" width="60" alt="PHP"/><br/>
      <b>PHP</b>
    </td>
    <td align="center">
      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" width="60" alt="MySQL"/><br/>
      <b>MySQL</b>
    </td>
  </tr>
</table>

**Características del backend**:
- Gestión de rutas y módulos.
- Autenticación JWT.
- Conexión y consultas con MySQL.
- Utilidades para el envío de emails y notificaciones.

---

## 📸 Imágenes de ejemplo
En la vista principal de la web ***(home)*** podemos observar varios carruseles sobre diferentes productos en la web
<p align="center">
    <img src="https://i.imgur.com/77B01Zy.png">
</p>
Al estar 30 minutos inactivo se te cierra la sesión por seguridad
<p align="center">
  <img src="https://i.imgur.com/5OgQLdW.png" width="40%">
</p>
Paginación en el apartado del shop donde puedes ir cambiando de página para ver los diferentes productos
<p align="center">
    <img src="https://i.imgur.com/rCaATcP.png">
</p>
Puedes filtrar productos según tus necesidades con las casillas desplegables situadas al lado de los productos en el shop
<p align="center">
    <img src="https://i.imgur.com/o9ur3o0.png" width="30%">
</p>
Abajo de los productos puedes ver un mapa para ver donde esta ubicado cada producto
<p align="center">
    <img src="https://i.imgur.com/NNxuKch.png">
</p>
En la vista de los detalles de un producto se pueden encontrar diferentes cosas sobre el producto, podemos encontrar las imágenes del producto en un carrusel para poder ir pasandolas, podemos ver el avatar y nombre de usuario a quien pertenece dicho producto, también podemos ver la valoración que tiene en estrellas y cuantos likes tiene el producto ademas de en la parte baja de los detalles del producto donde podemos ver los extras que tiene cada producto como por ejemplo saber si el producto admite envío o solamente admite venta en persona dependiendo de si el primer icono es un camión o una persona a parte de los de poder ver los demás extras como ver al lado del icono de la ubicación donde se situa el producto
<p align="center">
    <img src="https://i.imgur.com/4x800AP.png">
</p>
Si deslizamos más hacia abajo en el details podemos ver como tenemos una sección de productos relacionados con el producto que estemos viendo en dicho momento
<p align="center">
    <img src="https://i.imgur.com/GpeniYL.png">
</p>
Por último en los detalles del producto, abajo del todo hay un mapa donde se puede ver donde esta úbicado el producto con más exactitud que en la vista del shop ya que se ve con más zoom la ubicación del producto
<p align="center">
    <img src="https://i.imgur.com/JxyUwDv.png">
</p>
En la parte superior de la web se puede ver un buscador en el que podemos filtrar productos por su tipo categoria y ciudad para buscar más precisamente lo que el cliente desea
<p align="center">
    <img src="https://i.imgur.com/H345uhQ.png">
</p>

## 📁 Estructura del proyecto

```
/model         # Lógica de datos y conexión a la base de datos (PHP)
/module        # Módulos por funcionalidades (home, shop, auth, etc.)
/view          # Archivos estáticos: HTML, CSS, JS, imágenes
/utils         # Utilidades para el proyecto
/router        # Lógica de enrutamiento
/DB            # Archivos de la base de datos
```

---

## 📥 Instalación y despliegue

1. Clona el repositorio:
   ```bash
   git clone https://github.com/danisatorre/SegundaJugada-POO.git
   ```
2. Configura el servidor web (preferiblemente Apache) y la base de datos MySQL.
3. Ajusta los archivos de configuración de conexión según tus credenciales.
4. Recuerda que debes de añadir los archivos ***.ini*** con tus credenciales para que el proyecto funcione correctamente y el archivo ***FBsecret.js*** dentro de la carpeta utils con tus credenciales de firebase para poder logearse con usuarios de redes sociales
5. Accede a la web desde tu navegador.

---

**¡Gracias por visitar SegundaJugada-POO!**