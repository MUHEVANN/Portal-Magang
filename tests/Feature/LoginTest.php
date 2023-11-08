<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_feature_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'Admin@gmail.com',
            'password' => 'password',
            'g-recaptcha-response' => '03AFcWeA6AAetwKUgP178quRP5RwXYzkTRlcv_kIwRFOw7BzSKoxSxP_DibvYYJ1UpogEgbvsv7vP3O0LAvL6TbCsZx-vajtFtyUMSZycrumjieg06XN_UylWZ30vIlN9-jhgWZpGBYPr6767Jyycqm8A6gAP13WjmMO5pBvM_pDpqbYr4N47kFl9UEPZFjvcJ-ZKUxiIeb8WPt2R4Jqb8YpxXImJKcwrjUCDpLq13OhiFoEW8BHdBioWRSDapQZWK4jXF6ys6DioYfaBwy-7c0DiBho0n7ZQeE-kA02PHr5DTacUraF9EI_4D-dmzw522LADj4QYLM0M6-z91Q0pcYhkMCwaNgcfFNIYhbjEnKQBXMqzAnVci0LUk5YVRvlvxbdMnefW6g3AZEweb85PLZ-isvTvF8K6i5eIswHRefAiBUo-mb-VV5l4Ge36HEew-YAKWqqoE7HbbviFZpiCRwS1G98MSGGyBTn1X2Q0BFH_xT2t1VGNvY3DFEBNfc-pymfPHy-XVnhcFKl7X8XD-bl4sBBrPO0S9vZ5s9KsLnUmfKJh8q7oibuY3f9TikUqVZMw1JFN8ZtLJTOeQjd4Rkdkb6zRetdbmXqytQ30pJ6o6rrOVGw2_u_MP5a1GElOz2lAQOoJGZtT9p6QU06RG5A1hsJnPATwY_pAE1QnmHv-BTATTBUzGOTT5EgPm210ndZKRLy88IVFo7eT0CrWiJL5Ys2PZb35IlXOSWEnLdknAwa2IrLNdtr7P6BhdcBHfQYcSxLz-PsaSJYIYSHXv_ICVUWZUpo-GdTdZtFfps-QWxT69YOBkbfclavjdrATLNnfG8-u0MVbDQ2rdAHipjzkzn1du5mHvvSwK29VxzpCUvBhyyafl9RuKQZQbvhOjt41_4bPTLxAuAPBg8T6QCytYemtQmAzFXb8xdajcKA0vb0U2WzjKhGP8oR_28MPhIZfWDh1XhBadpIXO7UJ6qSodoprBgNsSMjQgivexrpG2HzmTKV8-AVth8xE1JT5o1gTeFYFLHdy_oE9r_wqva2G9L1ku63wBYxbvrbafNC3AuAGiGIIZmGaMLkUoFifgDxqofj3eVjH3OjTSEEcjoFe_OOYdzhEjzPlqM56Db5Gs4P_lf3iEHbE_IUVh2xy-ZY6k4yfuCw6MNbndubKnDdPIsVQ8b22xFITrTXwRQbbexOJ0GDTm-OwNsCAH1iOWnam39zIGeujBDbs9cD_ratelN2ZgDDaLR7wgUnQ0aagTlnttmdCodGdPq72zJNMlCe6UK10zYos5lZeUCKFz49liUAtaQyLOvXKResCY6mFo2EfmXW0PBw01MPDGCItE5Rryh-5dE57Z6soOBgCNqWSRwaP-TViHe6sgo2KmEIKZBotX-4QP-6w9C4NN1tJeVv9jlrvu-BLt0TynndWnw2CGQweTB24hbFSRlClo5nJ3HqfwSMNTqM45Ocjj-aKdaJFyfnr7S2VaHWMvTngm1hQkUB3k53fFybMHhfRW_W3fvnTBcP7399Tsis7pHwMWV5R4apCPFUuE'
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }
}
