<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Events Search API",
 *      description="Events searchAPI documentation",
 *      @OA\Contact(
 *          email="fgalvao90@yahoo.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url="http://localhost:8888/api",
 *      description="Events API Server"
 * )
 *
 *
 * @OA\Tag(name="UnAuthorize", description="No user login required")
 * @OA\Tag(name="Authorize", description="User login required")
 *
 * @OA\SecurityScheme(
 *       scheme="Bearer",
 *       securityScheme="Bearer",
 *       type="apiKey",
 *       in="header",
 *       name="Authorization",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
