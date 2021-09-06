import { FieldForm } from 'components';

export default function (props) {

    if (props.action === 'EDIT') {
        return {
            products: {
                title: 'Products',
                component: (props) => <FieldForm
                        compoment={'relationship_onetomany_show'}
                        config={{
                            title: 'Products',
                            object: 'ecom_prod',
                            field: 'ecom_prod_spec_sets',
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
    }

    return {};

}