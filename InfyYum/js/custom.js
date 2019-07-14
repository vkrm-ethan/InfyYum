function showOrders(prodid,uname,vendor,ordid) {

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              console.log(this.responseText);
              var splitString=this.responseText.split("~");
              var orderId=splitString[0];
              $('#ord-id').html(orderId);

              var prevOrders=splitString[1];
              var ordStatus=splitString[3];
              $('#ord-count').html(prevOrders);
              var intOrderscount=parseInt(prevOrders);
              var messsageUser="";
              if(intOrderscount>10 && ordStatus=="PENDING"){
              messsageUser="Please wait!!!! the counter is getting crowded";
            }else if(intOrderscount>5 && ordStatus=="PENDING"){
              messsageUser="Please wait!!!! your order is getting prepared";
              }
              else if(intOrderscount>1 && ordStatus=="PENDING"){
              messsageUser="Hey !!!! your order willl be ready in few minutes";

              }
              else if(intOrderscount==1 && ordStatus=="PENDING"){
              messsageUser="Hey !!!! your order is the next";
            }else if(ordStatus=="READY"){
                messsageUser="Grab your Food !!!";
                $('#ready-hide').hide();
              }else if(ordStatus=="COMPLETE"){
                messsageUser="Have a Good Meal";
              }
              $('#user-msg').html(messsageUser);
              var timeLeft=splitString[2];
              $('#time-left').html(timeLeft);
          }
      };
      xmlhttp.open("GET", "getDetails.php?uname="+uname+"&prodid="+prodid+"&vendor="+vendor+"&ordid="+ordid, true);
      xmlhttp.send();

}
