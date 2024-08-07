/**
 * External dependencies
 */
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

/**
 * The TypeScript Props for the Save Component. To learn more about Props and how to use them in TS,
 * visit https://www.typescriptlang.org/docs/handbook/interfaces.html
 */
interface SaveProps {
  attributes: {
    style?: string;
    color?: string;
    title?: string;
    textColor?: string;
    borderColor?: string;
  };
}

/**
 * IMPORTANT TO NOTE:
 * 
 * The Save Component should be consistent. While it is not that critical, if the Edit component changes, a change to the Save component or the attributes can be often breaking.
 * You will notice breaking changes in the editor, if the block asks to try updating the block for each instance.
 * 
 * The deprecationAPI should be used to handle these changes. To learn more about the deprecationAPI, 
 * visit https://developer.wordpress.org/block-editor/reference-guides/block-api/block-deprecation/
 * 
 * A working example can be found @https://github.com/RRZE-Webteam/rrze-elements-blocks/blob/main/src/accordion/deprecated.tsx
 */

/**
 * The Save Component – The Heart of the Block for the frontend. Each time a block is saved, updated or quicksaved,
 * this function is called to generate the HTML for the frontend.
 * @param param0
 * @returns
 */
export default function save({ attributes }: SaveProps) {
  const blockProps = useBlockProps.save();

  const createStyleObject = () => {
    if (attributes.style) {
      return {};
    }

    const styleObj: React.CSSProperties = {
      backgroundColor: attributes.color,
      color: attributes.textColor,
    };

    if (attributes.borderColor) {
      styleObj.border = `1px solid ${attributes.borderColor}`;
    }

    return styleObj;
  };

  const createTitle = () => {
    if (attributes.title && attributes.style === "example") {
      return attributes.title.replace(/"/g, "&quot;");
    }
    return undefined;
  };

  return (
    <div {...blockProps}>
      <div
        className={`alert clearfix clear ${
          attributes.style ? `alert-${attributes.style}` : ""
        }`}
        style={createStyleObject()}
        title={createTitle()}
      >
        <InnerBlocks.Content />
      </div>
    </div>
  );
}
