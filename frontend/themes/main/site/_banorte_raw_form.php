<form action="https://eps.banorte.com/secure3d/Solucion3DSecure.htm">
    <input type="hidden" name="Card" value="4915663039799581"/>
    <input type="hidden" name="Expires" value="10/22"/>
    <input type="hidden" name="Total" value="100"/>
    <input type="hidden" name="CardType" value="VISA"/>
    <input type="hidden" name="MerchantId" value="8373132"/>
    <input type="hidden" name="MerchantName" value="OPTIC PT"/>
    <input type="hidden" name="MerchantCity" value="JAL"/>
    <input type="hidden" name="ForwardPath" value="https://opticpt.com/index.php?r=banorte%2Fdefault%2F3d-secure-response"/>
    <input type="hidden" name="Cert3D" value="03"/>
    <input type="hidden" name="Reference3D" value="dasdasdasd<?= rand(1,10).rand(1,10).rand(1,10); ?>"/>
    <button type="submit">Submit</button>
</form>