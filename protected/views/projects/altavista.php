<?php
/* @var $this ProjectsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'',
);
?>
<?php Yii::app()->getClientScript()->registerCoreScript('sigma'); ?>
  <style>
    #graph-container {
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      position: absolute;
    }
    .sigma-edge {
      stroke: #14191C;
    }
    .sigma-node {
      stroke: #14191C;
      stroke-width: 2px;
    }
    .sigma-node:hover {
      fill: blue;
    }
    .muted {
      fill-opacity: 0.1;
      stroke-opacity: 0.1;
    }
  </style>
<div id="container">
  <div id="graph-container"></div>
</div>
<script>
/**
 * This is a basic example on how to instantiate sigma. A random graph is
 * generated and stored in the "graph" variable, and then sigma is instantiated
 * directly with the graph.
 *
 * The simple instance of sigma is enough to make it render the graph on the on
 * the screen, since the graph is given directly to the constructor.
 */
var i=1,
    s,
    g = {
      nodes: [],
      edges: []
    };

var ndsPj=<?php echo $nodesPj ?>;
var ndsPs=<?php echo $nodesPs ?>;
var edgs=<?php echo $edges ?>;
//alert(t);
var N=ndsPj.length;
var L=ndsPs.length;

ndsPj.forEach(function callback(currentValue, index, array) {
    currentValue.x=Math.random();
    currentValue.y=Math.random();
    currentValue.x= L * Math.cos(Math.PI * 2 * i / N - Math.PI / 2),
    currentValue.y= L * Math.sin(Math.PI * 2 * i / N - Math.PI / 2),
    i++;
    g.nodes.push(currentValue);
});

i=1;
ndsPs.forEach(function callback(currentValue, index, array) {
    currentValue.x=i - L/2;
    currentValue.y=i - L/2;
    i++;
    g.nodes.push(currentValue);
});


edgs.forEach(function callback(currentValue, index, array) {
    g.edges.push(currentValue);
});
// Generate a random graph:

// Instantiate sigma:
s = new sigma({
  graph: g,
    settings: {
            minNodeSize: 1,
            maxNodeSize: 60,
            enableHovering: false
          }

});

s.addRenderer({
  id: 'main',
  type: 'svg',
  container: document.getElementById('graph-container'),
  freeStyle: true
});

s.refresh();
//s.startForceAtlas2({worker: true, barnesHutOptimize: false});

function mute(node) {
  if (!~node.getAttribute('class').search(/muted/))
    node.setAttributeNS(null, 'class', node.getAttribute('class') + ' muted');
}

function unmute(node) {
  node.setAttributeNS(null, 'class', node.getAttribute('class').replace(/(\s|^)muted(\s|$)/g, '$2'));
}

$('.sigma-node').click(function() {

  // Muting
  $('.sigma-node, .sigma-edge').each(function() {
    mute(this);
  });

  // Unmuting neighbors
  var neighbors = s.graph.neighborhood($(this).attr('data-node-id'));
  neighbors.nodes.forEach(function(node) {
    unmute($('[data-node-id="' + node.id + '"]')[0]);
  });

  neighbors.edges.forEach(function(edge) {
    unmute($('[data-edge-id="' + edge.id + '"]')[0]);
  });
});


</script>
