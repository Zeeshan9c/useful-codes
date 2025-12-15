<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doughnut Chart with Detailed Labels, Animation, and Lines</title>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
.chart-container {
  position: relative;
  width: 359px;
  height: 359px;
  margin: 50px auto;
}

.flex-doughnut {
  display: block;
  margin: 0 auto;
}

.center-text-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: white;
  background-color: #333;
  border-radius: 50%;
  text-align: center;
}

.segment-label {
  position: absolute;
  transform: translate(-50%, -50%);
  background: rgba(255, 255, 255, 0.95);
  padding: 6px 12px;
  border-radius: 6px;
  font-family: Arial, sans-serif;
  font-size: 14px;
  font-weight: normal;
  pointer-events: none;
  white-space: nowrap;
  text-align: center;
}

.segment-label h4 {
  margin: 0 0 2px 0;
  font-size: 14px;
  font-weight: bold;
}

.segment-label p {
  margin: 0;
  font-size: 12px;
  color: #555;
}

.segment-line {
  position: absolute;
  width: 2px;
  background: #333;
  transform-origin: top left;
}
.segment-line {
	z-index: -1;
	background: red !important;
	height: 2px 
}
 
.segment-label {
	background: #fff;
}
</style>
</head>
<body>

<section class="doughnut-chart">
  <div class="chart-container">
    <svg class="flex-doughnut" width="359" height="359"></svg>
  </div>
</section>

<script>
function animateDoughnutWithLabels(segments, svg, strokeRatio = 0.18, startAngle = -90, centerText = "Center") {
    const container = $('.chart-container');
    svg.empty();
    container.find('.segment-label, .segment-line').remove();

    const width = svg.attr('width');
    const height = svg.attr('height');
    const centerX = width / 2;
    const centerY = height / 2;

    const maxRadius = Math.min(width, height) / 2;
    const radius = maxRadius * 0.9;
    const strokeWidth = radius * strokeRatio;
    const adjustedRadius = radius - strokeWidth / 2;

    const totalValue = segments.reduce((sum, s) => sum + s.value, 0);
    const circumference = 2 * Math.PI * adjustedRadius;

    const lengths = [];
    const labelPositions = [];
    const linePositions = [];
    let offset = 0;

    segments.forEach(seg => {
        const percent = seg.value / totalValue;
        const length = circumference * percent;
        lengths.push(length);

        const midAngle = startAngle + 360 * (offset / circumference) + 180 * percent;
        const rad = (midAngle * Math.PI) / 180;
        const labelRadius = adjustedRadius + strokeWidth / 2 + 40;

        const labelX = centerX + labelRadius * Math.cos(rad) + (seg.hOffset || 0);
        const labelY = centerY + labelRadius * Math.sin(rad) + (seg.vOffset || 0);
        labelPositions.push({ x: labelX, y: labelY });

        // Line target on the segment edge
        const segmentEdgeRadius = adjustedRadius + strokeWidth / 2;
        const lineX = centerX + segmentEdgeRadius * Math.cos(rad);
        const lineY = centerY + segmentEdgeRadius * Math.sin(rad);
        linePositions.push({ x: lineX, y: lineY });

        offset += length;
    });

    const circles = [];
    lengths.forEach((length, i) => {
        const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        circle.setAttribute("r", adjustedRadius);
        circle.setAttribute("cx", centerX);
        circle.setAttribute("cy", centerY);
        circle.setAttribute("fill", "transparent");
        circle.setAttribute("stroke", segments[i].color);
        circle.setAttribute("stroke-width", strokeWidth);
        circle.setAttribute("stroke-dasharray", `0 ${circumference}`);
        circle.setAttribute("stroke-dashoffset", -lengths.slice(0, i).reduce((a,b)=>a+b,0));
        circle.setAttribute("transform", `rotate(${startAngle} ${centerX} ${centerY})`);
        svg.append(circle);
        circles.push(circle);
    });

    // Add center text
    const foreign = document.createElementNS("http://www.w3.org/2000/svg", "foreignObject");
    const boxSize = adjustedRadius * 2 * 0.9 - 30;
    foreign.setAttribute("x", centerX - boxSize / 2);
    foreign.setAttribute("y", centerY - boxSize / 2);
    foreign.setAttribute("width", boxSize);
    foreign.setAttribute("height", boxSize);
    foreign.innerHTML = `<div class="center-text-wrapper">${centerText}</div>`;
    svg.append(foreign);

    let current = 0;
    function animateCircle() {
        if (current >= circles.length) {
            showLabelsAndLines();
            return;
        }

        const circle = circles[current];
        const targetLength = lengths[current];
        let progress = 0;
        const step = targetLength / 50;

        const anim = setInterval(() => {
            progress += step;
            if (progress >= targetLength) progress = targetLength;
            circle.setAttribute("stroke-dasharray", `${progress} ${circumference - progress}`);
            if (progress >= targetLength) {
                clearInterval(anim);
                current++;
                setTimeout(animateCircle, 150);
            }
        }, 10);
    }

    animateCircle();

    function showLabelsAndLines() {
        segments.forEach((seg, i) => {
            setTimeout(() => {
                const pos = labelPositions[i];

                // Add label
                const label = $(`
                    <div class="segment-label">
                        <h4>${seg.label}</h4>
                        <p>${seg.description}</p>
                    </div>
                `);
                label.css({ left: pos.x, top: pos.y });
                container.append(label);

                // Add line
                const linePos = linePositions[i];
                const dx = linePos.x - pos.x;
                const dy = linePos.y - pos.y;
                const length = Math.sqrt(dx*dx + dy*dy);
                const angle = Math.atan2(dy, dx) * 180 / Math.PI;

                const line = $('<div class="segment-line"></div>');
                line.css({
                    width: length + 'px',
                    left: pos.x + 'px',
                    top: pos.y + 'px',
                    transform: `rotate(${angle}deg)`
                });
                container.append(line);

            }, i * 300);
        });
    }
}

// Example usage
$(document).ready(function() {
    const svg = $('.flex-doughnut');
    const segments = [
        { color: "red", value: 79.1, label: "Red", description: "Main segment", hOffset: 0, vOffset: -40 },
        { color: "#36A2EB", value: 8.6, label: "Blue", description: "Secondary", hOffset: 30, vOffset: 0 },
        { color: "#FFCE56", value: 8.4, label: "Yellow", description: "Optional", hOffset: 30, vOffset: 0 },
        { color: "#4BC0C0", value: 12.9, label: "Cyan", description: "Extra", hOffset: 30, vOffset: 5 },
    ];

    animateDoughnutWithLabels(segments, svg, 0.18, 90, "Center Text");
});
</script>

</body>
</html>
