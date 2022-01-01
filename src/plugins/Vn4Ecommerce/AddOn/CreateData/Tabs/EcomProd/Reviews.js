import React from 'react'
import { FieldForm } from 'components';

function Reviews({ data }) {
    return (
        <FieldForm
            compoment={'relationship_onetomany_show'}
            config={{
                title: 'Reviews',
                object: 'ecom_prod_review',
                field: 'ecom_prod',
                view: "relationship_onetomany_show",
                paginate: {
                    rowsPerPage: 10
                }
            }}
            post={data.post}
            name={'reviews'}
            onReview={(value) => { }}
        />
    )
}

export default Reviews
