<?php
    class ParserDirectives extends \PHPUnit_Framework_TestCase
    {
        /**
         * @dataProvider stepContent
         * @param string $content
         * @covers RobotsTxtParser::step
         * @covers RobotsTxtParser::prepareRules
         * @covers RobotsTxtParser::zeroPoint
         * @covers RobotsTxtParser::readDirective
         * @covers RobotsTxtParser::skipSpace
         * @covers RobotsTxtParser::skipLine
         * @covers RobotsTxtParser::readValue
         */
        public function testStep($content)
        {
            $parser = $this
                ->getMockBuilder('RobotsTxtParser')
                ->disableOriginalConstructor()
                ->setMethods(array('step'))
                ->getMock();
            $this->assertInstanceOf('RobotsTxtParser', $parser);

            $contentLength = mb_strlen(trim($content)."\n");

            $parser
                ->expects($this->exactly($contentLength))
                ->method('step');

            $parser
                ->expects($this->atLeastOnce())
                ->method('zeroPoint');

            $parser
                ->expects($this->atLeastOnce())
                ->method('readDirective');

            $parser
                ->expects($this->atLeastOnce())
                ->method('skipSpace');

            $parser
                ->expects($this->atLeastOnce())
                ->method('skipLine');

            $parser
                ->expects($this->atLeastOnce())
                ->method('readValue');

            $parser
                ->setContent($content)
                ->prepareRules();
        }

        /**
         * Some generic content here.
         * We only need it to count the length
         * @return array
         */
        public function stepContent()
        {
            return array(
                array("
                    User-Agent: AhrefsBot
					Crawl-Delay: 1.5

					User-Agent: *
					Host: www.example.com
					Disallow : /admin
					Disallow#: /tech # ds
					Allow    :   /admin/front

					User-Agent: Yandex
					#Clean-param: utm_source_commented&comment
					Clean-param: utm_source&utm_medium&utm.campaign
                ")
            );
        }
    }
