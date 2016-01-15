jest.dontMock('../../javascript/src/example-component.js');

var ExampleComponent = require('../../javascript/src/example-component').default;

describe('ExampleComponent', () => {

    var component = new ExampleComponent();

    it('should do stuff', () => {
        expect(component.doStuff()).toBe(true);
    });
});
