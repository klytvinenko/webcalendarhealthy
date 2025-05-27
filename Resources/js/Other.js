
function href(url) {
    document.location.href = url;
}
function switchBlocks(block1_id, block2_id, block_activated = null) {
    const block1 = document.getElementById(block1_id);
    const block2 = document.getElementById(block2_id);

    if (block_activated === '1') {
        block1.style.display = "block";
        block2.style.display = "none";
    }
    else if (block_activated === '2') {
        block1.style.display = "none";
        block2.style.display = "block";
    }
    else if (block_activated == null) {
        if (block1.style.display == "none") {
            block1.style.display = "block";
            block2.style.display = "none";
        }
        else {
            block1.style.display = "none";
            block2.style.display = "block";
        }
    }
}
function Delete(url_,id) {
    const options = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json', 
        },
    };
    
    fetch(url_, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            console.log('Resource deleted successfully');
            let elem=document.getElementById(id);
            elem.className = "deleting";
            window.setTimeout(function() {
                // elem.parentNode.removeChild(el);
                elem.classList.add('hidden');
            }, 500);
        })
        .catch(error => {
            console.error('There was a problem with the DELETE request:', error.message);
        });
}
function log(text,label=""){
    if(label!="") console.log(label,text);
    else console.log(text)
}