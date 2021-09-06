
import { FieldForm } from 'components';

export default {
    products: {
        title: 'Products',
        component: (props) => <FieldForm
                compoment={'relationship_onetomany_show'}
                config={{
                    title: 'Products',
                    object: 'ecom_prod',
                    field: 'ecom_prod_cate',
                    view: "relationship_onetomany_show"
                }}
                post={props.data.post}
                name={'reviews'}
                onReview={(value) => { }}
            />
        ,
        priority: 2,
    },
};