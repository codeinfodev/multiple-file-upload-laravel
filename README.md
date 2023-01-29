# Multiple File Upload Laravel
Multiple File Upload With Progress Bar (Loader) in AWS S3 Bucket

In your application to use by updating the `AWS Config` variable in your .env file:
```env
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

Install aws library buy the following command.
```
composer require --with-all-dependencies league/flysystem-aws-s3-v3 "^1.0"
```

### Handle File Upload code in your controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    public function FileUpload(Request $request){

        $files = $request->file('files');
        if(count($files)){
            foreach($files as $file){
                // Store the file in the disk 
                Storage::disk('local')->put('documents/',$file,'public');
            }
        }
        return response()->json(['status'=>'OK']);
    }
}
```
### View Page
Create  File upload form using bootstrap
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multiple File Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">Multiple File Upload Laravel</div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="formFileLg" class="form-label">Choose Files *</label>
                        <input type="file" id="documents" class="form-control" multiple/>
                        <div class="mt-4">
                            <div class="progress" style="display: none">
                                <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    <span id="progress-percent">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="upload-documents"> Upload </button>    
                    <div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        $('#upload-documents').click(function(){
            this.disabled=true;
            const files = document.getElementById('documents').files;
            var formData = new FormData();
            if(files.length>0){
                for(let i=0; i<files.length;i++){
                    formData.append('files[]',files[i]);
                }
                axios.post(`{{url('/')}}/file-upload`,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function( progressEvent ) {
                            $('.progress').show();
                            var newprogress= parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
                            console.log(newprogress);
                            $('#progress-bar').attr('aria-valuenow', newprogress).css('width', newprogress+'%');
                            $('#progress-percent').html(`${newprogress}%`);
                        }
                    }
                    ).then(function(response){
                        console.log(response);
                    })
                    .catch(function(error){
                        console.log(error);
                    }
                );
            }
        });
        
    </script>
</body>
</html>
```