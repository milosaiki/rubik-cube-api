<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\SideRequestBodyMiddleware;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;

class SideRequestBodyMiddlewareTest extends \Tests\TestCase
{
    private Request|MockObject|null $requestMock;
    private SideRequestBodyMiddleware|null $middleware;

    public function setUp(): void
    {
        parent::setUp();
        $this->requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->middleware = new SideRequestBodyMiddleware();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->requestMock = null;
        $this->middleware = null;
    }
    /**
     * @dataProvider badRequestDataProvider
     */
    public function testHandleBadRequest(array $body, int $id): void
    {
        $this->requestMock->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn($id);
        $this->requestMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($body));
        $response = $this->middleware->handle($this->requestMock, function () {});

        $this->assertSame(400, $response->status());
    }

    /**
     * @dataProvider badIdDataProvider
     */
    public function testBadRouteId(int $id): void
    {
        $this->requestMock->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn($id);
        $response = $this->middleware->handle($this->requestMock, function () {});

        $this->assertSame(400, $response->status());
    }

    /**
     * @dataProvider bodyDataProvider
     */
    public function testHandle(array $body, int $id): void
    {
        $this->requestMock->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn($id);
        $this->requestMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode($body));
        $response = $this->middleware->handle($this->requestMock, function () {});
    }

    public function badRequestDataProvider()
    {
        return [
            [
                [
                    'direction' => 'upp',
                    'column' => 'middle'
                ],
                1
            ]
        ];
    }

    public function bodyDataProvider()
    {
        return [
            [
                [
                    'direction' => 'up',
                    'column' => 'middle'
                ],
                1
            ]
        ];
    }

    public function badIdDataProvider(): array
    {
        return [
            [10]
        ];
    }
}
