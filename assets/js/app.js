$(document).ready(function(){
    $(".bi-trash").click((e)=>{
        let sureDelete = confirm("Are you sure you want to delete?");
        if(sureDelete){
            e.target.nextElementSibling.submit();
        }
    })

    $(".form-check").click((e)=>{
        let checked = e.target.checked;
        checked = checked ? 1 : 0;

        if(checked == 1){
            e.target.parentElement.parentElement.classList.add("text-decoration-line-through");
        }else{
            e.target.parentElement.parentElement.classList.remove("text-decoration-line-through");
        }

        let id = e.target.id;

        $.ajax({
            method: "POST",
            url: "update.php",
            dataType: "json",
            data: {
                id : id,
                checked : checked
            }
        })
    });
});
