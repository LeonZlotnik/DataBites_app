function crearGrafica(json){
  var parsed = JSON.parse(json);
  var arr = [];
  for(var x in parsed){
    arr.push(parsed[x])
  }
    return arr;
}

function crearGraficaBar(json){
  var parsed = JSON.parse(json);
  var arr = [];
  for(var x in parsed){
    arr.push(parsed[x])
  }
    return arr;
}

function crearGraficaPie(json){
  var parsed = JSON.parse(json);
  return parsed;
}
      