<select class="InputFrmPre" id="id_curso">
    {section name=i loop=$lista}
        <option value="{$lista[i].id}" >{$lista[i].titulo}</option>
    {/section}
</select>