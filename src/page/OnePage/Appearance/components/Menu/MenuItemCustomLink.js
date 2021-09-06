import React from 'react'
import { AccordionActions, AccordionDetails, Button, Divider } from '@material-ui/core'
import FieldForm from 'components/FieldForm';
import { useAjax } from 'utils/useAjax';

function MenuItemCustomLink({ tree, setTree, listMenu, setListMenu }) {

    const [menuItem, setMenuItem] = React.useState({
        links: 'http://',
        label: ''
    });

    const {ajax} = useAjax();

    const addMenuItem = () => {
        ajax({
            url: 'menu/add-menu-item',
            method: 'POST',
            data: {
                type: 'getPostType',
                object_type: '__customLink',
                ...menuItem
            },
            success: (result) => {

                if (result.menus) {
                    let menuJson = [...tree];
                    menuJson = [...menuJson, ...result.menus];
                    listMenu.list_option[listMenu.value].json = menuJson;

                    setListMenu({ ...listMenu });
                    setTree(menuJson);
                }
            }
        });
    };


    return (
        <>
            <AccordionDetails style={{ flexDirection: 'column' }}>
                <div>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: 'URL'
                        }}
                        size='small'
                        post={menuItem}
                        name='links'
                        onReview={(value) => { setMenuItem({ ...menuItem, links: value }) }}
                    />
                </div>
                <div style={{ marginTop: 16 }}>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: 'Navigation Label'
                        }}
                        post={menuItem}
                        size='small'
                        name='label'
                        onReview={(value) => { setMenuItem({ ...menuItem, label: value }) }}
                    />
                </div>
            </AccordionDetails>
            <Divider />
            <AccordionActions style={{ justifyContent: 'flex-end' }}>
                <Button size="small" onClick={addMenuItem} color="primary">
                    Add to menu
                </Button>
            </AccordionActions>
        </>
    )
}

export default MenuItemCustomLink
