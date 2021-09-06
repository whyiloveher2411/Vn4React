import { Grid } from '@material-ui/core';
import { FieldForm } from 'components';
import React from 'react';
import { useRouteMatch } from 'react-router';
import { useAjax } from 'utils/useAjax';

function RelationshipOneToOneShowForm({ name, onReview, ...props }) {

    const { ajax } = useAjax();

    const match = useRouteMatch({
        path: "/post-type/:type/:action",
        strict: true,
    });

    const [data, setData] = React.useState(false);


    React.useEffect(() => {

        ajax({
            url: 'post-type/onetoone',
            method: 'POST',
            data: {
                postType: match.params.type,
                field: name,
                postId: props.post.id
            },
            success: (result) => {
                onReview(result.post);
                setData(result);
            }
        });

    }, [props.post.id]);

    const onChangeInputRepeater = (value, key) => {

        if (typeof key === 'object' && key !== null) {

            props.post[name] = {
                ...props.post[name],
                ...key
            };

        } else {

            props.post[name] = {
                ...props.post[name],
                [key]: value
            };
        }

        console.log('onChangeInputGroup', props.post[name]);

        console.log(props.post);
        onReview(props.post[name]);

    };

    if (data) {
        return <Grid
            container
            spacing={4}
        >
            {
                Object.keys(data.config.fields).map(key => {
                    return (
                        <Grid item md={12} xs={12} key={key} >
                            <FieldForm
                                compoment={data.config.fields[key].view ? data.config.fields[key].view : 'text'}
                                config={data.config.fields[key]}
                                post={data.post ?? {}}
                                name={key}
                                onReview={(value, key2 = key) => onChangeInputRepeater(value, key2)}
                            />
                        </Grid>
                    )
                })
            }
        </Grid>
    }

    return <></>;
}

export default RelationshipOneToOneShowForm
