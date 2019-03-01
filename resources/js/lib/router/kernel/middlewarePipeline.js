function middlewarePipeline (context, middleware, index = 0) {
    const nextMiddleware = middleware[index];

    if (! nextMiddleware) {
        return context.next;
    }

    return () => {
        const nextPipeline = middlewarePipeline(
            context, middleware, index + 1
        );

        nextMiddleware({ ...context, next: nextPipeline})
    }
}

export default middlewarePipeline;