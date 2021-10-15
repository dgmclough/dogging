function limit(){
  var count=0;
  //Get all elements with the class name of Boxes
  var boxes=document.getElementsByClassName('custom-control-input');

  //(this) is used to target the element triggering the function.
   for(var i=0; i<boxes.length; i++){
    //If checkbox is checked AND checkbox name is = to (this) checkbox name +1 to count
    if(boxes[i].checked&&boxes[i].name==this.name){count++;}
  }
  //If count is more then data-max="" of that element, uncheck last selected element
  if(count>this.getAttribute("data-max")){
    this.checked=false;
  }
}

window.onload=function(){
  var boxes=document.getElementsByClassName('custom-control-input');
  for(var i=0; i<boxes.length; i++){
    boxes[i].addEventListener('change',limit,false);
  }





}
