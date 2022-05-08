let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),idCliente(),nombreCliente(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",e=>{paso=e.target.dataset.paso,paso=parseInt(paso),mostrarSeccion(),botonesPaginador()})})}function mostrarSeccion(){ocultarSeccion();const e="#paso-"+paso;document.querySelector(e).classList.add("mostrar"),eliminarTab();document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function ocultarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar")}function eliminarTab(){const e=document.querySelector(".actual");e&&e.classList.remove("actual")}function botonesPaginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(e.classList.add("ocultar"),t.classList.remove("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",()=>{paso<=1||(paso--,botonesPaginador())})}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",()=>{paso>=3||(paso++,botonesPaginador())})}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$"+a,servicioDiv=document.createElement("DIV"),servicioDiv.classList.add("servicio"),servicioDiv.dataset.idServicio=t,servicioDiv.onclick=function(){seleccionarServicio(e)},servicioDiv.appendChild(n),servicioDiv.appendChild(c),document.querySelector("#servicios").appendChild(servicioDiv)})}function seleccionarServicio(e){const{servicios:t}=cita,{id:o}=e,a=document.querySelector(`[data-id-servicio="${o}"]`);t.some(e=>e.id===o)?(cita.servicios=t.filter(e=>e.id!==o),a.classList.remove("seleccionado")):(cita.servicios=[...t,e],a.classList.add("seleccionado"))}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",e=>{const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(mostrarAlerta("error","No Tenemos Servicio Los Fines De Semana",".contenido-cita"),e.target.value=""):cita.fecha=e.target.value})}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",e=>{const t=e.target.value,o=t.split(":")[0];o<10||o>=22?(mostrarAlerta("error","A Esa Hora No Tenemos Servicio",".contenido-cita"),e.target.value=""):cita.hora=t})}function mostrarResumen(){const e=document.querySelector(".contenido-resumen");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("error","Hacen Falta Seleccionar Servicios, Fecha u Hora",".contenido-resumen",!1);const{nombre:t,fecha:o,hora:a,servicios:n}=cita,c=document.createElement("H3");c.textContent="Tus Servicios A Solicitar",e.appendChild(c),n.forEach(t=>{const{id:o,nombre:a,precio:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const i=document.createElement("DIV");i.textContent=a;const r=document.createElement("DIV");r.innerHTML=`<span>Precio: $${n} </span>`,c.appendChild(i),c.appendChild(r),e.appendChild(c)});const i=document.createElement("P");i.innerHTML="<span>Nombre: </span> "+t;const r=new Date(o),s=r.getMonth(),d=r.getDate(),l=r.getFullYear(),u=new Date(Date.UTC(l,s,d+2)).toLocaleDateString("es-MX",{weekday:"long",day:"numeric",month:"long",year:"numeric"});console.log(u);const m=document.createElement("P");m.innerHTML="<span>Fecha: </span> "+u;const p=document.createElement("P");p.innerHTML="<span>Hora: </span> "+a;const v=document.createElement("H3");v.textContent="La Fecha y Hora A Reservar",e.appendChild(v);const h=document.createElement("DIV"),S=document.createElement("BUTTON");h.classList.add("alinear-derecha"),S.classList.add("boton"),S.textContent="Reservar Cita",S.onclick=reservarCita,h.appendChild(S),e.appendChild(i),e.appendChild(m),e.appendChild(p),e.appendChild(h)}async function reservarCita(){const{nombre:e,fecha:t,hora:o,servicios:a,id:n}=cita,c=a.map(e=>e.id),i=new FormData;i.append("fecha",t),i.append("hora",o),i.append("servicios",c),i.append("usuarioId",n);try{const e="http://localhost:3000/api/citas",t=await fetch(e,{method:"POST",body:i});(await t.json()).resultado&&Swal.fire({icon:"success",title:"Cita Reservada",text:"Tu Cita Fue Reservada Correctamente",button:"OK"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un Error al Reservar la Cita"})}}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=t,c.classList.add("alerta"),c.classList.add(e);document.querySelector(o).appendChild(c),a&&setTimeout(()=>{c.remove()},3e3)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));