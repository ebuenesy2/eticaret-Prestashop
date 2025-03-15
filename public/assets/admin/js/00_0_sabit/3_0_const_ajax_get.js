$(function () {
  
  alert("ajax - get js Kullanımı");
  console.log("ajax - get js çalışıyor");
  
  (async () => {
    const response = await fetch('/ajax/example/get');
    const resposeJson = await response.json();
    console.log(resposeJson); 
  })();

});