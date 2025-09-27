# 📊 Proyecto Superhéroes – Informe 4

Este proyecto implementa un sistema de análisis y visualización de datos sobre superhéroes.
El trabajo se centra en la creación de gráficos estadísticos, reportes PDF y cálculos de métricas relevantes.

---

## 📂 Informe 4

El informe está compuesto por dos gráficos principales:

### 🔹 Gráfico 1 – Distribución por Género

* **Fuente de datos**: Tabla `Gender`.
* **Descripción**: Muestra cuántos superhéroes existen según su género.
* **Salida**: Gráfico comparativo acompañado de una tabla resumen.

### 🔹 Gráfico 2 – Superhéroes por Editorial

* **Fuente de datos**: Tabla `Publisher_name`.
* **Editoriales seleccionadas**: IDs `4, 13, 3, 5, 10`.
* **Descripción**: Representa cuántos superhéroes pertenecen a cada editorial.
* **Salida**: Gráfico de barras mostrando el conteo por editorial.

---

## 🖥️ Funcionalidades del Proyecto

### Interfaz

* Selección de título de superhéroe.
* Filtro por género.
* Opción para limitar el número de resultados mostrados.

### Gráficos y Reportes

* **Gráfico dinámico**: Selección de editoriales mediante *checkbox*.
* **Exportación**: Generación de reportes en formato PDF con soporte de caché.

### Cálculos Avanzados

* **Promedio de peso por editorial**:

  * Cálculo del promedio de peso de todos los superhéroes agrupados por editorial (*publisher*).
  * Ordenamiento de los resultados de menor a mayor.
  * Visualización en un gráfico estadístico.

---

## ⚙️ Tecnologías Utilizadas

* **Backend**: PHP con CodeIgniter
* **Base de Datos**: MySQL
* **Frontend**: HTML5, CSS3, JavaScript
* **Visualización de datos**: Librerías gráficas (ej. Chart.js)
* **Reportes**: Generación de PDFs

---

## 📌 Conclusión

El proyecto combina **interfaz interactiva, análisis de base de datos y visualización gráfica** para ofrecer reportes claros y útiles sobre superhéroes.
El énfasis está en la presentación profesional de la información y la optimización del flujo de reportes.
