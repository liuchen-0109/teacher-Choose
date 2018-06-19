

<form action="/admin/test/excel" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/>
    {{ csrf_field() }}
    <input id="submit_form" type="submit" class="btn btn-success save" value="保存"/>
</form>