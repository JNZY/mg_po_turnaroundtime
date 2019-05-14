<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>

<script type="text/javascript">
	
	function success() {
	 if(document.getElementById("textsend").value==="") { 
            document.getElementById('button').disabled = true; 
        } else { 
            document.getElementById('button').disabled = false;
        }
    }
    function success1() {
    	 if(document.getElementById("textsend1").value==="") { 
                document.getElementById('button').disabled = true; 
            } else { 
                document.getElementById('button').disabled = false;
            }
        }


</script>

<body>

<textarea class="input" id="textsend" onkeyup="success()" name="demo" placeholder="Enter your Message..."></textarea>
<textarea class="input" id="textsend1" onkeyup="success1()" name="demo" placeholder="Enter your Message..."></textarea>

<button type="submit" id="button" disabled>Send</button>
</body>
</html>