<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bluesky Auth | blanka.lol</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        pre {
            border-radius: 15px;
            background-color: #E5E5E5;
        }
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">blanka.lol</h1>
    <h2 class="mt-5">Bluesky Auth</h2>
    <div id="handleForm">
        <form id="handleInputForm" method="post">
            <div class="mb-3">
                <label for="handle" class="form-label">Enter your Bluesky handle (without @)</label>
                <input type="text" class="form-control" id="handle" name="handle" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div id="verificationForm" style="display: none;">
        <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <form id="doneForm" method="post">
            <div class="mb-3">
                <label class="form-label">Please post this string in order to validate your ownership of the account <strong>@<span id="handleSpan"></span></strong></label>
                <pre id="randomString"></pre>
            </div>
            <input type="hidden" name="handle" id="handleInput">
            <input type="hidden" name="randomString" id="randomStringInput">
            <button type="submit" class="btn btn-primary">Done</button>
        </form>
    </div>
    <div id="successAlert" class="alert alert-success mt-3" style="display: none;">Your Bluesky account has been verified.</div>
    <div id="failAlert" class="alert alert-danger mt-3" style="display: none;">Failed to validate ownership. Please try again.</div>
    <div id="errorAlert" class="alert alert-danger mt-3" style="display: none;">Failed to validate ownership. Please try again.</div>
</div>

<script>
    document.getElementById("handleInputForm").addEventListener("submit", function (event) {
        event.preventDefault();
        var handle = document.getElementById("handle").value;
        document.getElementById("loadingOverlay").style.display = "flex";
        fetch("bsky-api-string.php", {
            method: "POST",
            body: new URLSearchParams({
                handle: handle
            }),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.randomString) {
                document.getElementById("handleForm").style.display = "none";
                document.getElementById("verificationForm").style.display = "block";
                document.getElementById("randomString").textContent = data.randomString;
                document.getElementById("handleSpan").textContent = handle;
                document.getElementById("handleInput").value = handle;
                document.getElementById("randomStringInput").value = data.randomString;
            }
        })
        .catch(error => {
            console.error("Error:", error);
        })
        .finally(() => {
            document.getElementById("loadingOverlay").style.display = "none";
        });
    });

    document.getElementById("doneForm").addEventListener("submit", function (event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById("doneForm"));
        document.getElementById("loadingOverlay").style.display = "flex";
        fetch("bsky-api-auth.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("verificationForm").style.display = "none";
                document.getElementById("successAlert").style.display = "block";
            } else {
                document.getElementById("verificationForm").style.display = "none";
                document.getElementById("failAlert").style.display = "block";
                setTimeout(function() {
                    window.location.reload();
                }, 5000);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            document.getElementById("verificationForm").style.display = "none";
            document.getElementById("errorAlert").style.display = "block";
            setTimeout(function() {
                    window.location.reload();
            }, 5000);
        })
        .finally(() => {
            document.getElementById("loadingOverlay").style.display = "none";
        });
    });
</script>
</body>
</html>
