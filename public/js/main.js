function salarytype(value)
{
    if(value == 0)
    {
        document.getElementById('salarytxtdiv').classList.remove('hidden');
    }
    else if(value == 1)
    {
        document.getElementById('salarytxtdiv').classList.remove('hidden');
    }
    else if(value == 2)
    {
        document.getElementById('salarytxtdiv').classList.add('hidden');
    }
    else
    {
        document.getElementById('salarytxtdiv').classList.add('hidden');
    }
}

async function pastelink(inputId) {
    try {
        // Get text from clipboard
        const copiedText = await navigator.clipboard.readText();

        // Find the input field by ID
        const inputField = document.getElementById(inputId);

        if (!inputField) {
            console.error("Input field not found: " + inputId);
            return;
        }

        // Paste the clipboard text into the input field
        inputField.value = copiedText;

    } catch (error) {
        console.error("Failed to paste clipboard text:", error);
    }
}

function toggleSidebar()
{
    if(document.getElementById('sidebar').classList.contains('hidden'))
    {
        document.getElementById('sidebar').classList.remove('hidden');
    }
    else
    {
        document.getElementById('sidebar').classList.add('hidden');
    }
}


document.getElementById('scanBtn').addEventListener('click', async () => {
    try {
        let res = await fetch("http://127.0.0.1:8090/scan");
        let data = await res.json();

        // Fingerprint Template Base64
        document.getElementById('fingerprintData').value = data.template;

        alert("Fingerprint Scanned Successfully!");
    } catch (e) {
        alert("Scanner not found. Please install the SDK.");
    }
});


function getfinderprint(rescan = 0)
{
    if(rescan == 1)
    {
        document.getElementById('spinnerfinger').classList.remove('hidden');
        document.getElementById('rescanbtn').classList.add('hidden');
        document.getElementById('errormsg_fingerscan').classList.add('hidden');
    }
    document.getElementById('fingerprintloadingModal').classList.remove('hidden');
    $.ajax({
        url: 'http://127.0.0.1:5000/capture', // ZKTeco local service endpoint
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if(data.success){
                document.getElementById('fingerprintloadingModal').classList.add('hidden');
                document.getElementById('fingerprintData').val(data.fingerprintTemplate);
            } else {
                document.getElementById('spinnerfinger').classList.add('hidden');
                document.getElementById('rescanbtn').classList.remove('hidden');
                document.getElementById('errormsg_fingerscan').classList.remove('hidden');
            }
        },
        error: function(xhr, status, error) {
            document.getElementById('spinnerfinger').classList.add('hidden');
            document.getElementById('rescanbtn').classList.remove('hidden');
            document.getElementById('errormsg_fingerscan').classList.remove('hidden');
        }
    });
}
function cancelscan()
{
    document.getElementById('fingerprintloadingModal').classList.add('hidden');
}