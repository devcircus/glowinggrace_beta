import store from 'JS/store';
import router from 'Libraries/router';
import middlewarePipeline from './kernel/middlewarePipeline';

const beforeEach = ((to, from, next) => {

    let middleware = to.matched.map( matched => {
        return matched.components.default.middleware;
    }).filter ( middleware => {
        return middleware !== undefined;
    }).flat();

    if (! middleware.length) {
        return next();
    }

    const context = {
        to,
        from,
        next,
        router,
        store,
    };

    if (middleware[0]) {
        return middleware[0]({ ...context, next:  middlewarePipeline(context, middleware, 1) });
    }
});

export default beforeEach;