<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload(){
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request){
        // dump($request->berkas);
        // return "Pemrosesan file upload di sini";
        $request->validate([
            'berkas' => 'required|file|image|max:5000',
        ]);
        // $path = $request->berkas->store('uploads');
        $extFile = $request->berkas->getClientOriginalName();
        $namaFile = 'web-'.time().".".$extFile;
        
        // $path = $request->berkas->storeAs('uploads',$namaFile);
        // $path = $request->berkas->storeAs('public',$namaFile);
        $path = $request->berkas->move('gambar',$namaFile);
        $path = str_replace("\\","//", $path);
        echo "Variabel path berisi:$path <br>";

        // $pathBaru = asset('storage/'.$namaFile);
        $pathBaru = asset('gambar/'.$namaFile);
        echo "proses upload berhasil, file berada di: $path";
        echo "<br>";
        echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        // echo $request->berkas->getClientOriginalName()." lolos validasi";

        // if($request->hasFile('berkas')){
        //     echo "path(): ".$request->berkas->path();
        //     echo "<br>";
        //     echo "extension(): ".$request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension(): ".$request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType(): ".$request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getClienOriginalName(): ".$request->berkas->getClientOriginalName();
        //     echo "<br>";
        //     echo "getSIze(): ".$request->berkas->getSize();
        // }else{
        //     echo "Tidak ada berkas yang diupload";
        // }
    }
}
