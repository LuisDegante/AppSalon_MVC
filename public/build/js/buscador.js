function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",n=>{const e=n.target.value;window.location=e?"?fecha="+e:"/admin"})}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));