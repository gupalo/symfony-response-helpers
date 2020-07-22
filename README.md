Symfony Response Helpers
========================

PublicFileResponse
------------------

Create BinaryFileResponse with correct headers for static files.

    PublicFileResponse::create($dir, $slug)
    
`$slug` can be filename, can be part of url like:

    * `/path/to/file.jpg?key=value&k2=v2#somehash`
    * `path/without/left/slash.png`

Other
-----

See `tests`.
