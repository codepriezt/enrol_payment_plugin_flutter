const btn = document.getElementById('sub_button').addEventListener('submit' , makeOrder)


function makeOrder()
{
    var str = '<?xml version="1.0" encoding="utf-8"?>'+
    '<SOAP-ENV:Envelope ' + 
    'xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" ' + 
    'xmlns:main="https://staging.payu.co.za/service/PAYU?wsdl" ' +
    'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' +
    'xmlns:xsd="http://www.w3.org/2001/XMLSchema">' +
    '<SOAP-ENV:Body>' +
        '<ns1:setT>' +
            '<main:countryCode>1</main:countryCode>' +
            '<main:webapiKey>xxxxxxxx</main:webapiKey>' +
        '</main:DoGetCountriesRequest>' +
    '</SOAP-ENV:Body>' +
'</SOAP-ENV:Envelope>'
}