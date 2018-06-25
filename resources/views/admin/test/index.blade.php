<style>
    img {
        max-width: 100%; /* This rule is very important, please do not ignore this! */
    }
</style>

<form action="/admin/test/excel" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/>
    {{ csrf_field() }}
    <input id="submit_form" type="submit" class="btn btn-success save" value="保存"/>
</form>

<div style="width:50%">
    <img id="image" src="/uploads/20180621/22a806d259bb284a5f80051eb1cced51.jpg">
</div>
<div style="width:50%"id = 'preview'>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.css">

<script>
    var image = document.getElementById('image');
    var cropper = new Cropper(image, {
        crop: function(event) {
        },
        previewL:"#preview",
        aspectRatio:1/1,
        ready:function(){
        }
    });



</script>


