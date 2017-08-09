<h1>{$TituloPagina}</h1>
<h3>These are the json data extracted from this date at your gmail:</h3>

{foreach from=$jsons key=i item=j}
    <h4>e-mail id = {$i}</h4>
    <pre>{$j}</pre>
{foreachelse}
    <p>Sorry... at this date there is no email with microdata to extract.</p>
{/foreach}