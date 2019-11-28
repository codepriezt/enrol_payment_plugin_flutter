<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * PayUMoney.com enrolment plugin - enrolment form.
 *
 * @package    enrol_flutter
 * @author     Codepriezt
 */


$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$amount = $cost;



//$invoice = date('Ymd') . "-" . $instance->courseid . "-" . hash('crc32', $txnid); //udf3
$_SESSION['timestamp'] = $timestamp = time();

//course1d userid instanceid contextid enrolperiod
$udf1 = $instance->courseid.'-'.$USER->id.'-'.$instance->id.'-'.$context->id.'-'.$instance->enrolperiod;


?>
<div align="center">
<p>This course requires a payment for entry.</p>
<p><b><?php echo $instancename; ?></b></p>
<p><b><?php echo get_string("cost").": {$instance->currency} {$localisedcost}"; ?></b></p>
<p>&nbsp;</p>
<p><img alt="PayUMoney" src="<?php echo $CFG->wwwroot; ?>/enrol/flutter/pix/index.png" /></p>
<p>&nbsp;</p>
<p>
	<form>
		<input type="hidden"  id="amount" name="amount" value="<?php echo $amount; ?>" />
		<input type="hidden"  id="txnid" name="txnid" value="<?php echo $txnid; ?>" />
		<input type="hidden"  id="email" name="email" value="<?php echo $USER->email; ?>" />
		<input type="hidden"  id="firstname" name="firstname" value="<?php echo $USER->firstname; ?>" />
		<input type="hidden"  id="phone" name="phone" value="<?php echo $_SESSION['timestamp']; ?>" />
        <input type="hidden"  id="courseid" name="courseid" value="<?php echo $instance->courseid; ?>" />
        <input type="hidden"  id="instanceid" name="instanceid" value="<?php echo $instance->id; ?>" />
        <input type="hidden"  id="contextid" name="contextid" value="<?php echo $context->id; ?>" />
        <input type="hidden" id = "surl" name="surl" value="<?php echo $CFG->wwwroot ?>/enrol/flutter/record.php"; />
        <input type="hidden"  id="userid" name="userid" value="<?php echo $USER->id; ?>" />
		<button type="button" id="sub_button" value="">Pay Now</button>
	</form>
</p>
</div>
<style type="text/css">
#sub_button{
  background: url("<?php echo $CFG->wwwroot; ?>/enrol/flutter/pix/index.png") no-repeat scroll 0 0 transparent;
  color: #000000;
  cursor: pointer;
  font-weight: bold;
  height: 20px;
  padding-bottom:2px;
  width: 301px;
  height: 59px;
}
</style>
<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script type ="text/javascript">
const btn = document.querySelector('#sub_button').addEventListener('click' , payWithRave);




function payWithRave(e){
   
	const Api_publicKey = "FLWPUBK_TEST-3ad6296c3414918d2327d0db4a653a03-X"
            var email = $('#email').val()
            var  amount = $('#amount').val()
            var  txnid = $('#txnid').val() 
            var courseid = $('#courseid').val()
            var userid =$('#userid').val()
            var instanceid = $('#instanceid').val()
            var contextid = $('#contextid').val()
            const currency = 'NG'?'NGN':'USD'
    
    

  var x = getpaidSetup({
            PBFPubKey: Api_publicKey ,
            customer_email: email,
			amount: amount,
            currency: currency,
            txref: txnid,
            meta: [{
                courseid:courseid
            }],
            onclose: function() {},
            callback: function(response) {
				var txref = response.tx.txRef; 
				var data = response
                if (response.tx.chargeResponseCode == "00" || response.tx.chargeResponseCode == "0") {

                    
            const form = {
                           'txref': txref,
                            'amount':amount,
                            'email':email,
                            'courseid':courseid,
                            'userid':userid,
                            'instanceid':instanceid,
                            'contextid':contextid,
                            'status':data.tx.status
             }
                    verify(form);
                } else {
                    console.log(data);
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    e.preventDefault();
    }


    function verify(form)
    {
        var url = $('#surl').val();

        var httpc = new XMLHttpRequest();

        const json = JSON.stringify(form);

        httpc.open("POST" , url);

        httpc.setRequestHeader("Content-Type", "application/json");

        httpc.onload = function()
        {
            console.log('Done :' , httpc.status)

            if(httpc.status == 200)
                {
                    location.assign(url);
                }
        }

       
        
        httpc.send(json);
      

    }


    

   
		
</script>




