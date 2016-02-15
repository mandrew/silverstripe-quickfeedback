<?php

class TestController extends Controller {
    /**
     * @var array
     */
    public static $allowed_actions = array(
        'form_appears_and_saves',
    );

    /**
     * @return HTMLText
     */
    public function form_appears_and_saves() {
        return $this->renderWith('TestController_form_appears_and_saves');
    }
}

/**
 * @mixin PHPUnit_Framework_TestCase
 */
class QuickFeedbackExtensionTest extends SapphireTest {
    /**
     * @test
     */
    public function form_appears_and_saves() {
        Config::inst()->update('Controller', 'extensions', array('QuickFeedbackExtension'));

        $controller = new TestController();
        $result = $controller->handleRequest(new SS_HTTPRequest('GET', 'form_appears_and_saves'), DataModel::inst());

        $body = $result->getBody();

        $this->assertContains('Form_QuickFeedbackForm', $body);
        $this->assertContains('Form_QuickFeedbackForm_Rating', $body);
        $this->assertContains('Form_QuickFeedbackForm_Comment', $body);

        preg_match('/action="([^"]+)"/', $body, $action);

        if (!count($action)) {
            $this->fail('No form action');
        }

        preg_match('/name="SecurityID" value="([^"]+)"/', $body, $token);

        if (!count($action)) {
            $this->fail('No token');
        }

        $parts = explode('/', $action[1]);
        $action = end($parts);

        $time = time();

        $data = array(
            'SecurityID' => $token[1],
            'Rating' => '0',
            'Comment' => 'comment at ' . $time,
        );

        $controller->handleRequest(new SS_HTTPRequest('POST', $action, array(), $data), DataModel::inst());

        $existing = Feedback::get()->filter('Comment', 'comment at ' . $time)->first();

        if (!$existing) {
            $this->fail('Record missing');
        }
    }
}
