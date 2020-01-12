

<div style="float:right">
        <form action="{{ route('home.upload.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="input04" tabindex="-1" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">

        <span class="group-span-filestyle input-group-btn" tabindex="0" >
            <label for="input04" style="margin-bottom: 0;" class="btn btn-secondary">
                <span class="iconify" data-icon="oi-folder"> </span>
                <span class="buttonText"> Charger un fichier</span>
            </label>
        </span>

        <button type="submit" class="btn btn-success">Upload</button>
</div>