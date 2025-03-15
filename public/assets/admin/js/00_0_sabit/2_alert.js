
    alert("alert js Kullanımı");
    console.log("Alert js çalışıyor");

    toastr.success("Başarılı"); //! Başarılı

 

    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'İşleminiz Başarılı',
        showConfirmButton: false,
        timer: 2000
    })