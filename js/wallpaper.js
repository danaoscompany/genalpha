var wallpapers = [];
var currentMember = "";

$(document).ready(function() {
    $("#upload-file").on('change', function(e) {
        var file = e.target.files[0];
        let fd = new FormData();
        fd.append("artist", currentMember);
        fd.append("file", file);
        fetch(PHP_URL+"/admin/upload_wallpaper", {
            method: 'POST',
            body: fd
        })
            .then(response => response.text())
            .then(response => {
                getWallpapersByMember(currentMember);
            });
    });
});

function getWallpapersByMember(member) {
    currentMember = member;
    wallpapers = [];
    $("#wallpapers").find("*").remove();
    let fd = new FormData();
    fd.append("artist", member);
    fetch(PHP_URL+"/user/get_wallpapers", {
        method: 'POST',
        body: fd
    })
        .then(response => response.text())
        .then(async (response) => {
            wallpapers = JSON.parse(response);
            for (let i=0; i<wallpapers.length; i++) {
                wallpapers[i]['opacity'] = 1;
                wallpapers[i]['cursor'] = 'pointer';
            }
            if ((wallpapers.length%5) != 0) {
                let remaining = 5-(wallpapers.length%5);
                for (let i=0; i<remaining; i++) {
                    wallpapers.push({opacity: 0, cursor: 'default'});
                }
            }
            for (let i=0; i<wallpapers.length; i+=5) {
                var row = "";
                row += "<div class='row' style='margin-top: 16px;'>";
                row += "<div class='col' style=\"position: relative; opacity: "+wallpapers[i]['opacity']+";\">" +
                    "   <img src='"+USERDATA_URL+"wallpapers/"+wallpapers[i]['path']+"' width='130px' height='250px' style=\"border-radius: 8px;\">" +
                    "   <div class='image-hover' style=\"position: absolute; top: 0; left: 16; width: 130px; height: 250px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; display: flex; justify-content: center; align-items: center;\">" +
                    "     <button onclick='confirmDeleteWallpaper("+i+", "+wallpapers[i]['id']+")' class='delete' style='cursor: "+wallpapers[i]['cursor']+";'>Hapus</button>"+
                    "   </div>" +
                    "</div>";
                row += "<div class='col' style=\"position: relative; opacity: "+wallpapers[i+1]['opacity']+";\">" +
                    "   <img src='"+USERDATA_URL+"wallpapers/"+wallpapers[i+1]['path']+"' width='130px' height='250px' style=\"border-radius: 8px;\">" +
                    "   <div class='image-hover' style=\"position: absolute; top: 0; left: 16; width: 130px; height: 250px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; display: flex; justify-content: center; align-items: center;\">" +
                    "     <button onclick='confirmDeleteWallpaper("+i+", "+wallpapers[i+1]['id']+")' class='delete' style='cursor: "+wallpapers[i+1]['cursor']+";'>Hapus</button>"+
                    "   </div>" +
                    "</div>";
                row += "<div class='col' style=\"position: relative; opacity: "+wallpapers[i+2]['opacity']+";\">" +
                    "   <img src='"+USERDATA_URL+"wallpapers/"+wallpapers[i+2]['path']+"' width='130px' height='250px' style=\"border-radius: 8px;\">" +
                    "   <div class='image-hover' style=\"position: absolute; top: 0; left: 16; width: 130px; height: 250px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; display: flex; justify-content: center; align-items: center;\">" +
                    "     <button onclick='confirmDeleteWallpaper("+i+", "+wallpapers[i+2]['id']+")' class='delete' style='cursor: "+wallpapers[i+2]['cursor']+";'>Hapus</button>"+
                    "   </div>" +
                    "</div>";
                row += "<div class='col' style=\"position: relative; opacity: "+wallpapers[i+3]['opacity']+";\">" +
                    "   <img src='"+USERDATA_URL+"wallpapers/"+wallpapers[i+3]['path']+"' width='130px' height='250px' style=\"border-radius: 8px;\">" +
                    "   <div class='image-hover' style=\"position: absolute; top: 0; left: 16; width: 130px; height: 250px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; display: flex; justify-content: center; align-items: center;\">" +
                    "     <button onclick='confirmDeleteWallpaper("+i+", "+wallpapers[i+3]['id']+")' class='delete' style='cursor: "+wallpapers[i+3]['cursor']+";'>Hapus</button>"+
                    "   </div>" +
                    "</div>";
                row += "<div class='col' style=\"position: relative; opacity: "+wallpapers[i+4]['opacity']+";\">" +
                    "   <img src='"+USERDATA_URL+"wallpapers/"+wallpapers[i+4]['path']+"' width='130px' height='250px' style=\"border-radius: 8px;\">" +
                    "   <div class='image-hover' style=\"position: absolute; top: 0; left: 16; width: 130px; height: 250px; background-color: rgba(0, 0, 0, 0.5); border-radius: 8px; display: flex; justify-content: center; align-items: center;\">" +
                    "     <button onclick='confirmDeleteWallpaper("+i+", "+wallpapers[i+4]['id']+")' class='delete' style='cursor: "+wallpapers[i+4]['cursor']+";'>Hapus</button>"+
                    "   </div>" +
                    "</div>";
                row += "</div>";
                $("#wallpapers").append(row);
            }
        });
}

function confirmDeleteWallpaper(index, id) {
    if (confirm("Apakah Anda yakin ingin menghapus wallpaper berikut?")) {
        let fd = new FormData();
        fd.append("id", id);
        fetch(PHP_URL+"/admin/delete_wallpaper_by_id", {
            method: 'POST',
            body: fd
        })
            .then(response => response.text())
            .then(response => {
                console.log("RESPONSE: "+response);
                getWallpapersByMember(currentMember);
            });
    }
}

function upload() {
    $("#upload-file").click();
}
