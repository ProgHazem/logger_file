<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Nette\FileNotFoundException;

class Home extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        try {
            if ($request->input("path")) {
                $path = $request->input("path");
                $content = array_reverse(\file($path));
                return view("/home")->with(["logs" => $content, "errors" => null]);
            } else{
                return view("/home")->with(["logs" => null, "errors" => null]);
            }
        } catch (FileNotFoundException $exception) {
            return view("/home")->with(["logs" => null, "errors" => $exception->getMessage()]);
        } catch (\ErrorException $exception) {
            return view("/home")->with(["logs" => null, "errors" => $exception->getMessage()]);
        } catch (\Exception $exception) {
            return view("/home")->with(["logs" => null, "errors" => $exception->getMessage()]);
        }
    }

}
