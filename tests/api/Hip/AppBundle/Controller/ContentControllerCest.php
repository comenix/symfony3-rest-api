<?php

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContentControllerCest
 */
class ContentControllerCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests

    /**
     * GET TESTING
     */

    public function getInvalidContent(ApiTester $I)
    {
        $I->wantTo('ensure getting an invalid Content id returns a 404 code');

        $I->sendGET(Page\ApiContent::route('/555'));
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }



    public function ensureDefaultResponseTypeIsJson(ApiTester $I)
    {
        $I->wantTo('ensure default response type is json');

        $I->sendGET(Page\ApiContent::route('/1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
    }

    public function getValidContent(ApiTester $I)
    {
        foreach ($this->validContentProvider() as $Id => $data) {
            $I->sendGET(Page\ApiContent::route('/' . $Id . '.json'));
            $I->seeResponseCodeIs(Response::HTTP_OK);
            $I->seeResponseIsJson();

            $I->seeResponseContainsJson($data);
        }
    }

    public function getContentsCollection(ApiTester $I)
    {
        $I->sendGET(Page\ApiContent::route());
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            array(
                'id' => 1,
                'title'  => 'home',
            ),
            array(
                'id' => 2,
                'title'  => 'about',
            )
        );
    }

    public function getContentsCollectionWithLimit(ApiTester $I)
    {
        $I->sendGET(Page\ApiContent::route('?limit=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array(
            array(
                'id' => 1,
                'title'  => 'home',
            ),
        ));
    }

    public function getContentsCollectionWithOffset(ApiTester $I)
    {
        $I->sendGET(Page\ApiContent::route('?offset=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array(
            'title'  => 'about'
        ));
    }

    public function getContentsCollectionWithLimitAndOffset(ApiTester $I)
    {
        $I->sendGET(Page\ApiContent::route('?offset=1&limit=3'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array(
            'title'  => 'about'
        ));
    }

    public function getContentsCollectionWithHateoasSelfHref(ApiTester $I)
    {
        $I->sendGET(Page\ApiContent::route('', false));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array(
            'href'  => '/api/v1/contents/1'
        ));
    }

    /**
     * POST TESTING
     */

    public function postWithEmptyFieldsReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPOST(Page\ApiContent::route(), array());

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }


    public function postWithBadFieldsReturn400ErrorCode(ApiTester $I)
    {
        $I->sendPOST(Page\ApiContent::route(), ['bad_field' => 'qwerty']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function postWithValidDataReturns201WithHeader(ApiTester $I)
    {
        // add the time to the title so it's unique(ish)
        $title = 'api testing ' . date('H:i:s');
        $I->sendPOST(Page\ApiContent::route(), ['title' => $title, 'body' => 'test has passed']);

        $Id = $I->grabFromDatabase('contents', 'id', ['title' => $title]);

        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/' . $Id));
    }

    /**
     * PUT TESTING
     */

    public function putWithInvalidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPUT(Page\ApiContent::route('/214234.json'), array(
            'qwerty' => 'asdfgh',
        ));

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithInvalidIdAndValidDataCreatesNewResourceAndReturns201(ApiTester $I)
    {
        $title = 'example with invalid id';
        $body  = 'and valid data';

        $I->sendPUT(Page\ApiContent::route('/5555.json'), array(
            'title' => $title,
            'body' => $body,
        ));

        $Id = $I->grabFromDatabase('contents', 'id', array(
            'title'  => $title
        ));

        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/' . $Id));
    }

    public function putWithValidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPUT(Page\ApiContent::route('/2.json'), array(
            'ytrewq' => 'qwerty',
        ));

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function putWithValidIdAndValidDataReplacesExistingDataAndReturns204(ApiTester $I)
    {
        $title = 'valid id - new and improved title';
        $body  = 'valid data - new content here';

        $I->sendPUT(Page\ApiContent::route('/2.json'), array(
            'title' => $title,
            'body' => $body,
        ));

        $newTitle = $I->grabFromDatabase('contents', 'title', array(
            'id'  => 2
        ));

        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/2'));
        $I->assertEquals($title, $newTitle);
    }


    /**
     * PATCH TESTING
     */

    public function patchWithInvalidIdReturns404(ApiTester $I)
    {
        $I->sendPATCH(Page\ApiContent::route('/5555.json'), ['qwerty' => 'abcdef']);
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function patchWithValidIdAndInvalidDataReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPATCH(Page\ApiContent::route('/2.json'), ['qwerty' => 'abcdef']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function patchWithValidIdAndValidDataReturns204(ApiTester $I)
    {
        $title        = 'valid id - newly patched title';
        $originalBody = "<h1>About</h1><p>stuff</p>";

        // send the patch
        $I->sendPATCH(Page\ApiContent::route('/2.json'), array(
            'title' => $title,
        ));

        // get the new title and existing body
        $newTitle = $I->grabFromDatabase('contents', 'title', array(
            'id'  => 2
        ));

        $existingBody = $I->grabFromDatabase('contents', 'body', array(
            'id'  => 2
        ));

        // ensure the response code, header location, title is correct, and body hasn't changed
        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
        // full route is required because the location returns the full url
        $I->canSeeHttpHeader('Location', Page\ApiContent::fullRoute('/2'));
        $I->assertEquals($title, $newTitle);
        $I->assertEquals($originalBody, $existingBody);
    }


    /**
     * DELETE TESTING
     */

    public function deleteWithInvalidArtistReturns404(ApiTester $I)
    {
        $I->sendDELETE(Page\ApiContent::route('/555555.json'));

        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    public function deleteWithValidArtistReturns204(ApiTester $I)
    {
        $I->seeInDatabase('contents', array(
            'id'    => 1,
        ));

        $I->sendDELETE(Page\ApiContent::route('/1.json'));

        $I->dontSeeInDatabase('contents', array(
            'id'    => 1,
        ));

        $I->seeResponseCodeIs(Response::HTTP_NO_CONTENT);
    }


    /**
     * @return array
     */
    private function validContentProvider()
    {
        return [1 => ['title' => 'home'], 2 => ['title' => 'about']];
    }
}
