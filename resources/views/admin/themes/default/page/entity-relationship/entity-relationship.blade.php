@extends(backend_theme('master'))

@section('content')

<?php 
 title_head( 'Entity Relationship' );
 $posts = get_admin_object();

 $relationships = ['relationship_onetoone'=>['1','1'],'relationship_onetomany'=>['0..N','1'],'relationship_manytomany'=>['N','N']];
 ?>
<div class="">
   <div id="sample" style="position: relative;">

   <span style="display: inline-block;position: absolute;width: 200px;height: 100px;background: white;z-index: 111;top: 1px;left: 1px;pointer-events: none;"></span>
  <div id="myDiagramDiv" style="background-color: white; border: solid 1px black; width: 100%; height: 800px"></div>
  
</div>
</div>
@stop

@section('js')
  <script src="@asset(admin/js/erd.js)"></script>

  <script id="code">

  $(window).load(function(){
    function init() {
      if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
      var $ = go.GraphObject.make;  // for conciseness in defining templates

      myDiagram =
        $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
          {
            allowDelete: false,
            allowCopy: false,
            layout: $(go.ForceDirectedLayout),
            "undoManager.isEnabled": true
          });

      var colors = {
        'red': '#be4b15',
        'green': '#52ce60',
        'blue': '#6ea5f8',
        'lightred': '#fd8852',
        'lightblue': '#afd4fe',
        'lightgreen': '#b9e986',
        'pink': '#faadc1',
        'purple': '#d689ff',
        'orange': '#fdb400',
        'primary':'#8100d2',
      }

      // the template for each attribute in a node's array of item data
      var itemTempl =
        $(go.Panel, "Horizontal",
          $(go.Shape,
            { desiredSize: new go.Size(15, 15), strokeJoin: "round", strokeWidth: 3, stroke: null, margin: 2 },
            new go.Binding("figure", "figure"),
            new go.Binding("fill", "color"),
            new go.Binding("stroke", "color")),
          $(go.TextBlock,
            {
              stroke: "#333333",
              font: "bold 14px sans-serif"
            },
            new go.Binding("text", "name"))
        );

      // define the Node template, representing an entity
      myDiagram.nodeTemplate =
        $(go.Node, "Auto",  // the whole node panel
          {
            selectionAdorned: true,
            resizable: true,
            layoutConditions: go.Part.LayoutStandard & ~go.Part.LayoutNodeSized,
            fromSpot: go.Spot.AllSides,
            toSpot: go.Spot.AllSides,
            isShadowed: true,
            shadowOffset: new go.Point(3, 3),
            shadowColor: "#C5C1AA"
          },
          new go.Binding("location", "location").makeTwoWay(),
          // whenever the PanelExpanderButton changes the visible property of the "LIST" panel,
          // clear out any desiredSize set by the ResizingTool.
          new go.Binding("desiredSize", "visible", function(v) { return new go.Size(NaN, NaN); }).ofObject("LIST"),
          // define the node's outer shape, which will surround the Table
          $(go.Shape, "RoundedRectangle",
            { fill: 'white', stroke: "#eeeeee", strokeWidth: 3 }),
          $(go.Panel, "Table",
            { margin: 8, stretch: go.GraphObject.Fill },
            $(go.RowColumnDefinition, { row: 0, sizing: go.RowColumnDefinition.None }),
            // the table header
            $(go.TextBlock,
              {
                row: 0, alignment: go.Spot.Center,
                margin: new go.Margin(0, 24, 0, 2),  // leave room for Button
                font: "bold 16px sans-serif"
              },
              new go.Binding("text", "key")),
            // the collapse/expand button
            $("PanelExpanderButton", "LIST",  // the name of the element whose visibility this button toggles
              { row: 0, alignment: go.Spot.TopRight }),
            // the list of Panels, each showing an attribute
            $(go.Panel, "Vertical",
              {
                name: "LIST",
                row: 1,
                padding: 3,
                alignment: go.Spot.TopLeft,
                defaultAlignment: go.Spot.Left,
                stretch: go.GraphObject.Horizontal,
                itemTemplate: itemTempl
              },
              new go.Binding("itemArray", "items"))
          )  // end Table Panel
        );  // end Node

      // define the Link template, representing a relationship
      myDiagram.linkTemplate =
        $(go.Link,  // the whole link panel
          {
            selectionAdorned: true,
            layerName: "Foreground",
            reshapable: true,
            routing: go.Link.AvoidsNodes,
            corner: 5,
            curve: go.Link.JumpOver
          },
          $(go.Shape,  // the link shape
            { stroke: "#303B45", strokeWidth: 2.5 }),
          $(go.TextBlock,  // the "from" label
            {
              textAlign: "center",
              font: "bold 14px sans-serif",
              stroke: "#1967B3",
              segmentIndex: 0,
              segmentOffset: new go.Point(NaN, NaN),
              segmentOrientation: go.Link.OrientUpright
            },
            new go.Binding("text", "text")),
          $(go.TextBlock,  // the "to" label
            {
              textAlign: "center",
              font: "bold 14px sans-serif",
              stroke: "#1967B3",
              segmentIndex: -1,
              segmentOffset: new go.Point(NaN, NaN),
              segmentOrientation: go.Link.OrientUpright
            },
            new go.Binding("text", "toText"))
        );
    

      // create the model for the E-R diagram
      var nodeDataArray = [

        @foreach($posts as $p)
        {

          key: "{!!$p['title']!!}",
          items: [
            { name: "id", iskey: true, figure: "Decision", color: colors.primary },
            @foreach($p['fields'] as $f)

            @if( isset($f['view']) && is_string($f['view']) &&  isset($relationships[$f['view']]) )
            { name: "{!!$f['title']!!}", iskey: true, figure: "Decision", color: colors.red },
            @else
            { name: "{!!$f['title']!!}", iskey: false, figure: "Hexagon", color: colors.blue },
            @endif
            @endforeach
          ]
          // { name: "SupplierID", iskey: false, figure: "Decision", color: "purple" },
          // { name: "CategoryID", iskey: false, figure: "Decision", color: "purple" }]
        },
        @endforeach
        
      ];
      var linkDataArray = [

        @foreach($posts as $key => $p)
          @foreach($p['fields'] as $f)

           @if(  isset($f['view']) && is_string($f['view']) && isset($relationships[$f['view']]) )
            { from: "{!!$p['title']!!}", to: "{!!$posts[$f['object']]['title']!!}", text: "{!!$relationships[$f['view']][0]!!}", toText: "{!!$relationships[$f['view']][1]!!}" },
           @endif
          @endforeach
        @endforeach

        // { from: "Products", to: "Categories", text: "0..N", toText: "1" },
        // { from: "Order Details", to: "Products", text: "0..N", toText: "1" }
      ];
      myDiagram.model = $(go.GraphLinksModel,
        {
          copiesArrays: true,
          copiesArrayObjects: true,
          nodeDataArray: nodeDataArray,
          linkDataArray: linkDataArray
        });
    }

    init();
  });
  </script>
@stop
